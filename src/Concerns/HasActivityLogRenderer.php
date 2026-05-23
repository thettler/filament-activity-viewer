<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer\Concerns;

use BackedEnum;
use donatj\UserAgent\UserAgentParser;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Facades\Filament;
use Filament\Infolists\Components\CodeEntry;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Operation;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\View\View;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Thettler\FilamentActivityViewer\Data\Tag;
use Thettler\FilamentActivityViewer\Formatters\EnumFormatter;

trait HasActivityLogRenderer
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ActivityContract $activity;

    public function getIcon(): string | null | BackedEnum
    {
        return $this->subjectIcon() ?? $this->icon;
    }

    public function getSecondaryIcon(): string | null | BackedEnum
    {
        return $this->secondaryIcon;
    }

    /**
     * @return (ValueFormatter|class-string<ValueFormatter>)[]
     */
    public function getCasts(): array
    {
        return $this->casts;
    }

    public function getColor(): string | array | Color | null
    {
        return $this->color;
    }

    public function formatAttributeName(string $name, mixed $value): string
    {
        return Str::headline($name);
    }

    public function formatAttributeValue(mixed $value, string $name): string | Htmlable | null | int | float | bool | array
    {
        $casts = array_filter(
            $this->getCasts(),
            fn (string $key): bool => str_starts_with($key, $name),
            ARRAY_FILTER_USE_KEY
        );

        $cast = $casts[$name] ?? null;
        unset($casts[$name]);
        if (! $cast) {
            return $value;
        }

        if (count($casts) <= 1) {
            return $this->castValue($cast, $value, $name);
        }

        $value = $this->castValue($cast, $value, $name);

        return collect($casts)->mapWithKeys(
            fn (mixed $cast, $key) => [
                str_replace($name . '.', '', $key) => str_replace($name . '.', '', $key)
                        |> (fn ($x) => Arr::get($value, $x))
                        |> (fn ($x) => $this->castValue($cast, $x, $key)),
            ],
        )
            ->toArray();
    }

    protected function castValue(mixed $cast, mixed $value, string $name): mixed
    {
        if ($cast instanceof ValueFormatter) {
            return $cast->format($value, $name, $this->activity->attribute_changes['attributes'] ?? [], $this);
        }

        if (enum_exists($cast)) {
            return new EnumFormatter($cast)->format(
                $value,
                $name,
                $this->activity->attribute_changes['attributes'] ?? [],
                $this
            );
        }

        return new $cast()->format($value, $name, $this->activity->attribute_changes['attributes'] ?? [], $this);
    }

    public function title(): string | null | Htmlable | View | array
    {
        return [
            $this->causerLinkTag(),
            $this->description(),
            $this->subjectLinkTag(),
        ];
    }

    public function description(): string | null | Htmlable | View
    {
        return $this->activity->description;
    }

    public function content(): string | null | Htmlable | View
    {
        if (empty($this->activity->attribute_changes)) {
            return null;
        }

        return view('filament-activity-viewer::components.basic-content', ['activity' => $this]);
    }

    public function meta(): string | null | Htmlable | View
    {
        $meta = $this->activity->properties['meta'] ?? null;
        if ($meta === null) {
            return null;
        }

        $parser = new UserAgentParser;
        $userAgent = $parser->parse($meta['user_agent']);
        $ip = $meta['ip'] ?? null;
        $origin = $meta['origin'] ?? null;

        return view(
            'filament-activity-viewer::components.basic-meta',
            [
                'activity' => $this,
                'userAgent' => $userAgent,
                'origin' => $origin,
                'ip' => $ip,
            ]
        );
    }

    public function created_at(): string
    {
        return $this->activity->created_at->diffForHumans();
    }

    public function created_at_tooltip(): ?string
    {
        return $this->activity->created_at->format('Y-m-d H:i:s');
    }

    public function causerName(): string | Htmlable
    {
        if (! $this->activity->causer) {
            return 'Anonymous';
        }

        return $this->getResourceTitle($this->activity->causer);
    }

    public function causerUrl(): ?string
    {
        if (! $this->activity->causer) {
            return null;
        }
        $url = $this->getResourceUrl($this->activity->causer, Operation::View->value);
        $url ??= $this->getResourceUrl($this->activity->causer, Operation::Edit->value);

        return $url;
    }

    public function causerLinkTag(): null | string | Htmlable
    {
        return new HtmlString(
            <<<HTML
<a x-on:click.stop
   class="font-bold"
   href="{$this->causerUrl()}">
    {$this->causerName()}
</a>
HTML
        );
    }

    public function subject(): ?Model
    {
        return once(fn () => $this->activity->subject);
    }

    public function subjectName(): string | Htmlable
    {
        return $this->getResourceTitle($this->subject());
    }

    public function subjectType(): string | Htmlable
    {
        return $this->getResourceFallbackType($this->subject());
    }

    public function subjectIcon(): string | Htmlable | BackedEnum | null
    {
        return $this->getResourceIcon($this->subject());
    }

    public function subjectUrl(): ?string
    {
        $url = $this->getResourceUrl($this->subject(), Operation::View->value);
        $url ??= $this->getResourceUrl($this->subject(), Operation::Edit->value);

        return $url;
    }

    public function subjectLinkTag(): null | string | Htmlable
    {
        return new HtmlString(
            <<<HTML
<a class="font-bold"
   href="{$this->subjectUrl()}">
    {$this->subjectName()}
</a>
HTML
        );
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('filament-activity-viewer::components.default-activity');
    }

    #[\Thettler\FilamentActivityViewer\Attributes\Action]
    public function rawDataAction(): Action
    {
        return Action::make('rawData')
            ->label('Raw Activity Data')
            ->icon(Heroicon::CodeBracket)
            ->schema([
                CodeEntry::make('data')
                    ->hiddenLabel()
                    ->jsonFlags(JSON_PRETTY_PRINT)
                    ->state($this->activity->toArray()),
            ])
            ->modalSubmitAction(false)
            ->modalCancelAction(false)
            ->modal();
    }

    public function getActions(): array
    {
        $reflection = new ReflectionClass($this);

        $actions = collect($reflection->getMethods(ReflectionMethod::IS_PUBLIC))
            ->filter(function (ReflectionMethod $method) {
                if (! $method->getAttributes(\Thettler\FilamentActivityViewer\Attributes\Action::class)) {
                    return false;
                }

                return $method->getReturnType()?->getName() === Action::class;
            })
            ->map(function (ReflectionMethod $method) {
                return $method->invoke($this);
            })
            ->all();

        return $actions;
    }

    public function getTags(): array
    {
        return [
            new Tag(
                label: $this->subjectType()
            ),
            new Tag(
                label: $this->activity->event,
                color: $this->getColor(),
                icon: $this->getSecondaryIcon(),
            ),
        ];
    }

    protected function getResourceUrl(Model $model, string $operation): ?string
    {
        try {
            return Filament::getResourceUrl($model, $operation);
        } catch (InvalidArgumentException $exception) {
            if (! str_contains($exception->getMessage(), 'No Filament resource found for model')) {
                throw $exception;
            }

            return null;
        }
    }

    protected function getResourceTitle(Model $model): string
    {
        /** @var class-string<\Filament\Resources\Resource>|null $resource */
        $resource = Filament::getModelResource($model);
        if (! $resource) {
            return $this->getResourceFallbackTitle($model);
        }

        return $resource::getRecordTitle($model) ?? $this->getResourceFallbackTitle($model);
    }

    protected function getResourceIcon(Model $model): string | BackedEnum | null | Htmlable
    {
        /** @var class-string<\Filament\Resources\Resource>|null $resource */
        $resource = Filament::getModelResource($model);
        if (! $resource) {
            return $this->getResourceFallbackTitle($model);
        }

        return $resource::getNavigationIcon();
    }

    protected function getResourceType(Model $model): string
    {
        /** @var class-string<\Filament\Resources\Resource>|null $resource */
        $resource = Filament::getModelResource($model);

        if (! $resource) {
            return $this->getResourceFallbackType($model);
        }

        return $resource::getModelLabel() ?? $this->getResourceFallbackType($model);
    }

    protected function getResourceFallbackTitle(Model $model): string
    {
        return $this->getResourceFallbackType($model) . ':' . $model->getKey();
    }

    protected function getResourceFallbackType(Model $model): string
    {
        return class_basename($model);
    }
}

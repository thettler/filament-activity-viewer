<?php

namespace Thettler\FilamentActivityViewer\Concerns;

use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use ReflectionClass;
use ReflectionMethod;
use Thettler\FilamentActivityViewer\Formatters\DateValueFormatter;
use Thettler\FilamentActivityViewer\Formatters\RelationValueFormatter;
use Thettler\FilamentActivityViewer\Formatters\RichTextFormatter;

trait UsesSubjectAsSource
{
    public function getCasts(): array
    {
        /** @var Model&HasRichContent $subject */
        $subject = $this->activity->subject;
        $modelCasts = $subject->getCasts();
        $relation = $this->getRelations($subject);
        $richTextAttributes = $subject instanceof HasRichContent ? $subject->getRichContentAttributes() : [];
        $richTextAttributes = array_map(fn () => RichTextFormatter::class, $richTextAttributes);

        $casts = array_map(function (string $cast) {
            if (str_starts_with($cast, 'date')) {
                $parts = explode(':', $cast, 2);
                $type = $parts[0];
                $format = $parts[1] ?? null;

                return $format ? new DateValueFormatter($format) : DateValueFormatter::class;
            }

            if (enum_exists($cast)) {
                return $cast;
            }

            $eloquentCast = explode(':', $cast, 2);
            if (class_exists($eloquentCast[0]) && in_array(
                ValueFormatter::class,
                class_implements($eloquentCast[0])
            )) {
                return isset($eloquentCast[1]) ? $eloquentCast[0] : new $eloquentCast[0]($eloquentCast[1] ?? null);
            }

            if (class_exists($eloquentCast[0]) && in_array(
                HasValueFormatter::class,
                class_implements($eloquentCast[0])
            )) {
                return $eloquentCast[0]::useFormatter($eloquentCast[1] ?? null);
            }

            if (config('filament-activity-viewer.formatters')[$eloquentCast[0]] ?? false) {
                return isset($eloquentCast[1])
                    ? new (config('filament-activity-viewer.formatters')[$eloquentCast[0]])($eloquentCast[1])
                    : (config('filament-activity-viewer.formatters')[$eloquentCast[0]]);
            }

            return null;
        }, $modelCasts) |> array_filter(...);

        return [
            'created_at' => DateValueFormatter::class,
            'updated_at' => DateValueFormatter::class,
            'deleted_at' => DateValueFormatter::class,
            ...$relation,
            ...$casts,
            ...$richTextAttributes,
        ];
    }

    protected function getRelations(Model $model)
    {
        $reflection = new ReflectionClass($model);
        $relations = array_filter(
            $reflection->getMethods(ReflectionMethod::IS_PUBLIC),
            fn (ReflectionMethod $method) => $method->getReturnType()?->getName() === BelongsTo::class
        );

        $relations = collect($relations)
            ->mapWithKeys(function (ReflectionMethod $method) use ($model) {
                /** @var BelongsTo $belongsTo */
                $belongsTo = $method->invoke($model);

                return [$belongsTo->getForeignKeyName() => new RelationValueFormatter($method->getName())];
            });

        return $relations;
    }
}

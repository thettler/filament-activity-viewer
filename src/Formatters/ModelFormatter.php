<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer\Formatters;

use Filament\Facades\Filament;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Enums\Operation;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Thettler\FilamentActivityViewer\Concerns\Activity;
use Thettler\FilamentActivityViewer\Concerns\ValueFormatter;

final class ModelFormatter implements ValueFormatter
{
    /**
     * @param  class-string<Model>|Model  $model
     */
    public function __construct(public Model | string $model, public ?string $label = null) {}

    public function format(
        mixed $value,
        string $attributeName,
        array $attributes,
        Activity $activity
    ): string | Htmlable | View | null | int | float | bool | array {
        $model = is_string($this->model) ? $this->model::find($value) : $this->model;

        if (! $model) {
            return null;
        }

        if ($this->label !== null) {
            $label = $model->{$this->label};
        } elseif ($model instanceof HasLabel) {
            $label = $model->getLabel();
        } else {
            $label = $model->getKey();
        }

        if ($url = $this->findeResourceUrl($model)) {
            return view('filament-activity-viewer::components.link', [
                'slot' => $label,
                'href' => $url,
            ]);
        }

        return $label;
    }

    protected function findeResourceUrl($model, Operation $operation = Operation::View): ?string
    {
        try {
            return Filament::getResourceUrl($model, $operation->value);
        } catch (\InvalidArgumentException $exception) {
            if (! str_contains($exception->getMessage(), 'No Filament resource found for model')) {
                throw $exception;
            }

            return null;
        }
    }
}

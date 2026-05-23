<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer\Formatters;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\View;
use Thettler\FilamentActivityViewer\Concerns\Activity;
use Thettler\FilamentActivityViewer\Concerns\ValueFormatter;

final class RelationValueFormatter implements ValueFormatter
{
    public function __construct(public string $relation, public ?string $label = null) {}

    public function format(
        mixed $value,
        string $attributeName,
        array $attributes,
        Activity $activity
    ): string | Htmlable | View | null | int | float | bool | array {
        $relation = $activity->subject()?->{$this->relation};

        if (! $relation) {
            return null;
        }

        if ($this->label) {
            return $relation->{$this->label};
        }

        if ($relation instanceof HasLabel) {
            return $relation->getLabel();
        }

        if ($label = config('filament-activity-viewer.relation_labels')[$relation::class] ?? null) {
            return $relation->{$label};
        }

        return $relation->getKey();
    }
}

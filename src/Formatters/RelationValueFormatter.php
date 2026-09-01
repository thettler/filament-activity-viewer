<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer\Formatters;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
        $relation = $activity->subject()
            ?->{$this->relation}()
            ->getRelated()
            ->newQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->find($value);

        if (! $relation) {
            return null;
        }
        $labelAttribute = $this->label ?? config('filament-activity-viewer.relation_labels')[$relation::class] ?? null;

        $formatter = new ModelFormatter($relation, $relation->{$labelAttribute} ?? null);

        return $formatter->format($value, $attributeName, $attributes, $activity);
    }
}

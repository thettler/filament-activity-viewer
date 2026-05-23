<?php

namespace Thettler\FilamentActivityViewer\Formatters;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\View;
use Thettler\FilamentActivityViewer\Concerns\Activity;
use Thettler\FilamentActivityViewer\Concerns\ValueFormatter;

class AsEnumCollectionFormatter implements ValueFormatter
{
    public function __construct(public string $enum) {}

    public function format(
        mixed $value,
        string $attributeName,
        array $attributes,
        Activity $activity
    ): string | Htmlable | View | null | int | float | bool | array {
        return array_map(
            fn (mixed $item) => new EnumFormatter($this->enum)->format($item, $attributeName, $attributes, $activity),
            $value
        );
    }
}

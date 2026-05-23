<?php

namespace Thettler\FilamentActivityViewer\Formatters;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Thettler\FilamentActivityViewer\Concerns\Activity;
use Thettler\FilamentActivityViewer\Concerns\ValueFormatter;

class DateValueFormatter implements ValueFormatter
{
    public function __construct(public string $format = 'Y-m-d H:i:s') {}

    public function format(
        mixed $value,
        string $attributeName,
        array $attributes,
        Activity $activity
    ): string | Htmlable | View | null | int | float | bool | array {

        if (! $value) {
            return null;
        }

        return Carbon::parse($value)->format($this->format);
    }
}

<?php

namespace Thettler\FilamentActivityViewer\Formatters;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\View;
use Thettler\FilamentActivityViewer\Concerns\Activity;
use Thettler\FilamentActivityViewer\Concerns\ValueFormatter;

class JsonFormatter implements ValueFormatter
{
    /**
     * @param  class-string<\BackedEnum>  $enum
     */
    public function __construct()
    {
    }

    public function format(
        mixed $value,
        string $attributeName,
        array $attributes,
        Activity $activity
    ): string|Htmlable|View|null|int|float|bool|array {
        if (!$value) {
            return null;
        }

        if (json_validate($value)) {
            return json_decode($value, true);
        }
        return $value;
    }
}

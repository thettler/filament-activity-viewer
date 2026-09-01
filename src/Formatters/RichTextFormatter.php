<?php

namespace Thettler\FilamentActivityViewer\Formatters;

use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\View;
use Thettler\FilamentActivityViewer\Concerns\Activity;
use Thettler\FilamentActivityViewer\Concerns\ValueFormatter;

class RichTextFormatter implements ValueFormatter
{
    /**
     * @param  class-string<\BackedEnum>  $enum
     */
    public function __construct() {}

    public function format(
        mixed $value,
        string $attributeName,
        array $attributes,
        Activity $activity
    ): string | Htmlable | View | null | int | float | bool | array {
        if (! $value) {
            return null;
        }

        return RichContentRenderer::make($value);
    }
}

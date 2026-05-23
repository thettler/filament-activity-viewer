<?php

namespace Thettler\FilamentActivityViewer\Formatters;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\View;
use Thettler\FilamentActivityViewer\Concerns\Activity;
use Thettler\FilamentActivityViewer\Concerns\ValueFormatter;

class EnumFormatter implements ValueFormatter
{
    /**
     * @param  class-string<\BackedEnum>  $enum
     */
    public function __construct(public string $enum) {}

    public function format(
        mixed $value,
        string $attributeName,
        array $attributes,
        Activity $activity
    ): string | Htmlable | View | null | int | float | bool | array {

        $enum = $this->enum::tryFrom($value ?? '');
        if (!$enum) {
            return null;
        }
        return view('filament-activity-viewer::components.enum', [
            'label' => $enum instanceof HasLabel ? $enum->getLabel() : $enum->name,
            'color' => $enum instanceof HasColor ? $enum->getColor() : null,
            'icon' => $enum instanceof HasIcon ? $enum->getIcon() : null,
        ]);
    }
}

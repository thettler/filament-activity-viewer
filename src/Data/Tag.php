<?php

namespace Thettler\FilamentActivityViewer\Data;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

class Tag implements HasColor, HasIcon, HasLabel
{
    public function __construct(
        public string | Htmlable | null $label,
        public string | BackedEnum | Htmlable | null $icon = null,
        public string | array | null $color = null,
    ) {}

    public function getColor(): string | array | null
    {
        return $this->color;
    }

    public function getIcon(): string | BackedEnum | Htmlable | null
    {
        return $this->icon;
    }

    public function getLabel(): string | Htmlable | null
    {
        return $this->label;
    }
}

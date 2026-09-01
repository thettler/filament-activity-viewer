<?php

namespace Thettler\FilamentActivityViewer\Components;

use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Colors\Color;
use Livewire\Component;
use Thettler\FilamentActivityViewer\Concerns\Activity;
use Thettler\FilamentActivityViewer\Concerns\HasActivityLogRenderer;

class DefaultActivity extends Component implements Activity, HasActions, HasSchemas
{
    use HasActivityLogRenderer;

    public null | string | \BackedEnum $icon = null;

    public string | \BackedEnum | null $secondaryIcon = null;

    public string | array | Color | null $color = null;

    public array $casts = [];
}

<?php

namespace Thettler\FilamentActivityViewer\Components;

use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\View;

class RestoreActivity extends DefaultActivity
{
    public string | \BackedEnum | null $secondaryIcon = Heroicon::ArrowUturnLeft;

    public string | array | Color | null $color = 'info';

    public function content(): Htmlable | string | View | null
    {
        return null;
    }
}

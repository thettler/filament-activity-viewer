<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer\Components;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Thettler\FilamentActivityViewer\Concerns\UsesSubjectAsSource;

final class UpdateActivity extends DefaultActivity
{
    use UsesSubjectAsSource;

    public string | BackedEnum | null $secondaryIcon = Heroicon::OutlinedPencilSquare;

    public string | array | Color | null $color = 'primary';
}

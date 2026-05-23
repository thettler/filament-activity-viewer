<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer\Components;

use BackedEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;
use Thettler\FilamentActivityViewer\Concerns\UsesSubjectAsSource;

final class CreateActivity extends DefaultActivity
{

    use UsesSubjectAsSource;

    public string|BackedEnum|null $secondaryIcon = Heroicon::Plus;

    public string|array|Color|null $color = 'success';


}

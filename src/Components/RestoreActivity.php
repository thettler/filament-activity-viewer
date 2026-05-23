<?php

namespace Thettler\FilamentActivityViewer\Components;


use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\RestoreAction;
use Filament\Infolists\Components\CodeEntry;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Thettler\FilamentActivityViewer\Concerns\Activity;
use Thettler\FilamentActivityViewer\Concerns\HasActivityLogRenderer;
use Thettler\FilamentActivityViewer\Concerns\UsesSubjectAsSource;

class RestoreActivity extends DefaultActivity
{

    public string|\BackedEnum|null $secondaryIcon = Heroicon::ArrowUturnLeft;

    public string|array|Color|null $color = 'info';

    public function content(): \Illuminate\Contracts\Support\Htmlable|string|\Illuminate\View\View|null
    {
        return null;
    }
}

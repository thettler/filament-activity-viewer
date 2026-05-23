<?php

namespace Thettler\FilamentActivityViewer\Components;

use Filament\Actions\Action;
use Filament\Actions\RestoreAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\View;

class DeletedActivity extends DefaultActivity
{
    public string | \BackedEnum | null $secondaryIcon = Heroicon::Trash;

    public string | array | Color | null $color = 'danger';

    #[\Thettler\FilamentActivityViewer\Attributes\Action]
    public function restoreAction(): Action
    {
        return RestoreAction::make('restore')
            ->action(function (Action &$action): void {
                if (! method_exists($this->subject(), 'restore')) {
                    $action->failure();

                    return;
                }

                $result = $this->subject()->restore();

                if (! $result) {
                    $action->failure();

                    return;
                }

                $action->success();
            })
            ->authorize('restore', $this->subject())
            ->visible(function (): bool {
                if (! method_exists($this->subject(), 'trashed')) {
                    return false;
                }

                return $this->subject()?->trashed();
            });
    }

    public function content(): Htmlable | string | View | null
    {
        return null;
    }
}

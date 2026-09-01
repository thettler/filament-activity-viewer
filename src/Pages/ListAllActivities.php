<?php

namespace Thettler\FilamentActivityViewer\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;
use Thettler\FilamentActivityViewer\Components\DefaultActivity;
use UnitEnum;

class ListAllActivities extends Page
{
    use WithPagination;

    protected string $view = 'filament-activity-viewer::pages.list-all-activities';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Square3Stack3d;

    protected static ?string $navigationLabel = 'All Activities';

    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return filament('filament-activity-viewer')->getNavigationGroup();
    }

    public function getBreadcrumb(): string
    {
        return static::$breadcrumb ?? __('filament-activity-viewer::activities.breadcrumb');
    }

    public function getTitle(): string
    {
        return __('filament-activity-viewer::activities.all.title');
    }

    protected function getEventMap()
    {
        return config('filament-activity-viewer.events');
    }

    #[Computed]
    public function activities()
    {
        return Activity::with('causer')
            ->latest()
            ->paginate()
            ->through(function (Activity $activity) {
                if ($component = $this->getEventMap()[$activity->event] ?? false) {
                    return ['activity' => $activity, 'component' => $component];
                }

                if (class_exists($activity->event) && is_subclass_of(
                    $activity->event,
                    \Thettler\FilamentActivityViewer\Concerns\Activity::class
                )) {
                    return ['activity' => $activity, 'component' => $activity->event];
                }

                return [
                    'activity' => $activity,
                    'component' => config('filament-activity-viewer.events.default', DefaultActivity::class),
                ];
            });
    }
}

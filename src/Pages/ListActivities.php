<?php

namespace Thettler\FilamentActivityViewer\Pages;

use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;
use Thettler\FilamentActivityViewer\Components\DefaultActivity;

class ListActivities extends Page implements HasForms
{
    use InteractsWithRecord;
    use WithPagination;

    protected static Collection $fieldLabelMap;

    protected string $view = 'filament-activity-viewer::pages.list-all-activities';

    protected static string | null | \BackedEnum $navigationIcon = Heroicon::Square3Stack3d;

    protected static ?string $navigationLabel = 'Activities';

    public function mount(int | string $record)
    {
        $this->record = $this->resolveRecord($record);
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
        return $this->record->activities()
            ->with('causer')
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

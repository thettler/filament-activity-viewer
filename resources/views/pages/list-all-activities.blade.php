@php
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\IconSize;
    use Filament\Support\View\Components\SectionComponent\IconComponent;

    use Illuminate\View\ComponentAttributeBag;
    use function Filament\Support\is_slot_empty;
@endphp

<x-filament-panels::page>

    {{-- Content --}}
    <x-filament::section
            compact>
        <x-slot name="header">
            <h2 class="text-2xl font-bold tracking-tight">
                {{ __('filament-panels::pages/activities.title') }}
            </h2>
        </x-slot>
        <div class="flow-root mb-10">
            <ul role="list" class="-mb-8">
                @foreach($this->activities as $activity)
                    <livewire:dynamic-component :is="$activity['component']" :activity="$activity['activity']" :wire:key="$activity['activity']->id" />
                @endforeach
            </ul>
        </div>

        <x-filament::pagination :paginator="$this->activities" />

    </x-filament::section>

</x-filament-panels::page>

<div class="font-mono text-xs items-center  mt-2 text-gray-700 dark:text-gray-200 flex gap-2 justify-end" x-data="{expand: false}">
    <x-filament::icon-button @click="()=>expand =!expand"
                             x-bind:class="{'rotate-180': expand}"
                             color="gray"
                             :icon="\Filament\Support\Icons\Heroicon::ChevronLeft->getIconForSize(\Filament\Support\Enums\IconSize::Small)">
    </x-filament::icon-button>


    <x-filament::badge icon="heroicon-o-cursor-arrow-rays" :tooltip="'Origin: '. $origin"  color="gray">
       <span x-show="expand">{{$origin}}</span>
    </x-filament::badge>

    <div class="bg-gray-700 w-px"></div>

    @php
        $browser = $userAgent->platform().' '.$userAgent->browser().' '.$userAgent->browserVersion();
    @endphp
    <x-filament::badge icon="heroicon-o-computer-desktop" :tooltip="'Browser: '. $browser" color="gray">
        <span x-show="expand">{{$browser}}</span>
    </x-filament::badge>

    <div class="bg-gray-700 w-px"></div>

    <x-filament::badge  icon="heroicon-o-globe-alt" :tooltip="'IP Address: '. $ip" color="gray">
        <span x-show="expand">{{$ip}}</span>
    </x-filament::badge>
</div>

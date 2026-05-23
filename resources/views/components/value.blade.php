@php use Filament\Support\Enums\IconSize;use Filament\Support\Icons\Heroicon; @endphp
@php
$value = $value();
@endphp
@if(is_bool($value))
    <x-filament-activity-viewer::bool :value="$value" :attribute-name="$attributeName" />
@elseif(empty($value))
    <x-filament::badge color="gray">EMPTY</x-filament::badge>
@elseif(is_array($value))
    @foreach($value as $key => $item)
        @if($item instanceof \Illuminate\View\View)
            {!! $item !!}
        @else
            @if(is_string($key))
                <div x-data="{ open: true }" class="py-2">
                    <button type="button"
                            x-on:click="open = ! open"
                            class="font-semibold flex block items-center">
                        <span x-show="open">
                        @svg(Heroicon::ChevronDown->getIconForSize(IconSize::Small), 'size-[1em]')
                        </span>
                        <span x-show="!open">
                        @svg(Heroicon::ChevronRight->getIconForSize(IconSize::Small), 'size-[1em]')
                        </span>

                        {{$key}}:
                    </button>
                    <div x-show="open" class="pl-1.5 ml-1.5 border-l border-gray-400">
                        <x-filament-activity-viewer::value :value="fn()=>$item" :attribute-name="$attributeName" />
                    </div>
                </div>
            @else
                <x-filament-activity-viewer::value :value="fn()=>$item" :attribute-name="$attributeName" />
            @endif
        @endif
    @endforeach
@elseif($value instanceof \Illuminate\View\View)
    {!! $value !!}
@elseif( $value instanceof \Illuminate\Contracts\Support\Htmlable)
    {{ $value }}
@elseif(\Illuminate\Support\Str::isUrl($value))
    <x-filament::link target="_blank" href="{{$value}}">{{$value}}</x-filament::link>
@else
    {{$value}}
@endif

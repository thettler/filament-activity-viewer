<li>
    <div class="relative pb-8">
                        <span aria-hidden="true"
                              class="absolute left-6 top-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-white/10"></span>
        <div class="relative flex items-start space-x-3">
            <div class="relative px-1">
                <div class="flex size-10 fi-text-color-600 overflow-hidden items-center justify-center rounded-full bg-gray-100 ring-10 ring-white dark:bg-gray-800 dark:ring-gray-900">
                    {{
                        \Filament\Support\generate_icon_html(
                            icon: $this->getIcon(),
                            attributes: (new \Illuminate\View\ComponentAttributeBag())
                            ->class(['text-[var(--color-600)] bg-[var(--color-500)]/10 w-full h-full p-1.5'])
                            ->color(\Filament\Schemas\View\Components\IconComponent::class, $this->getColor()),
                            size:  \Filament\Support\Enums\IconSize::Large)
                    }}

                </div>
                @if($this->getSecondaryIcon())
                    <div class="absolute -bottom-0.5 -right-1 rounded-full bg-white px-0.5 py-px dark:bg-gray-900">
                        {{
                  \Filament\Support\generate_icon_html(
                      icon: $this->getSecondaryIcon(),
                      attributes: (new \Illuminate\View\ComponentAttributeBag())
                      ->class(['text-[var(--color-600)] bg-[var(--color-500)]/10'])
                      ->color(\Filament\Schemas\View\Components\IconComponent::class, $this->getColor()),
                      size:  \Filament\Support\Enums\IconSize::Medium)
              }}
                    </div>
                @endif
            </div>
            <div class="min-w-0 flex-1 py-1.5 space-y-2">
                <div class="flex justify-between mb-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <div>
                            @php
                                $title = $this->title()
                            @endphp
                            @if(is_string($title) || $title instanceof \Illuminate\Support\HtmlString)
                                {{ $title }}
                            @elseif($title instanceof \Illuminate\View\View)
                                {!! $title !!}
                            @elseif(is_array($title))
                                @foreach($title as $line)
                                    @if(is_string($line) || $line instanceof \Illuminate\Support\HtmlString)
                                        {{ $line }}
                                    @elseif($title instanceof \Illuminate\View\View)
                                        {!! $line !!}
                                    @endif
                                @endforeach
                            @endif
                            <span class="whitespace-nowrap"
                                  x-tooltip="{ content: @js($this->created_at_tooltip()), theme: $store.theme }"
                            >{{$this->created_at()}}</span>
                        </div>
                        @if(!empty($this->getTags()))
                            <div class="flex items-center gap-2">
                                @foreach($this->getTags() as $tag)
                                    <x-filament::badge
                                            :color="$tag->getColor()"
                                            :icon="$tag->getIcon()"
                                    >
                                        {{$tag->getLabel()}}
                                    </x-filament::badge>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <x-filament-actions::group :actions="$this->getActions()" />

                </div>
                @php
                    $content = $this->content()
                @endphp
                @if($content)
                    <div class="mt-2 text-sm text-gray-700 dark:text-gray-200">
                        @if(is_string($content) || $content instanceof \Illuminate\Support\HtmlString)
                            {{ $content }}
                        @elseif($content instanceof \Illuminate\View\View)
                            {!! $content !!}
                        @endif
                    </div>
                @endif
                @php
                    $meta = $this->meta()
                @endphp
                @if($meta)
                    <div class="mt-2 text-sm text-gray-700 dark:text-gray-200">
                        @if(is_string($meta) || $meta instanceof \Illuminate\Support\HtmlString)
                            {{ $meta }}
                        @elseif($meta instanceof \Illuminate\View\View)
                            {!! $meta !!}
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-filament-actions::modals/>

</li>

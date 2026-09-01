@php
    /** @var \Illuminate\Support\Collection $changes */
      $changes =   $activity->activity->attribute_changes;
@endphp
@if($changes->isNotEmpty())
    <div class="-mx-4 ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg dark:ring-white/15">
        <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
            <thead>
            <tr>
                <th scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 dark:text-white">Field
                </th>
                @if($changes->has('old'))
                    <th scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">
                        Old
                    </th>
                @endif

                @if($changes->has('attributes'))
                    <th scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell dark:text-white">
                        New
                    </th>
                @endif

            </tr>
            </thead>
            <tbody>
            @foreach(($changes['attributes'] ?? $changes['old'] ?? []) as $key => $attribute)
                <tr class="even:bg-gray-50 dark:even:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800/90">

                    <td class="relative py-2 pl-3 pr-2 text-sm sm:pl-6">
                        <div class="font-medium text-gray-900 dark:text-white">
                            {{$this->formatAttributeName($key, $attribute)}}
                        </div>
                        <div class="mt-1 flex flex-col text-gray-500/10 sm:block lg:hidden dark:text-gray-400">
                            <span>
                            </span>
                        </div>
                    </td>
                    @if($changes->has('old'))
                        <td class="hidden px-3 py-2 text-sm bg-red-500/5 dark:bg-red-500/10 text-gray-500 lg:table-cell dark:text-gray-400">
                            @php
                                $value = $this->formatAttributeValue($changes['old'][$key] ?? null, $key);
                            @endphp
                            @include('filament-activity-viewer::components.value',['value' => fn()=> $value, 'attributeName' => $key])
                        </td>
                    @endif
                    @if($changes->has('attributes'))
                        <td class="hidden px-3 py-2 text-sm text-gray-500 bg-green-500/5 dark:bg-green-500/10 lg:table-cell dark:text-gray-400">
                            @php
                                $value = $this->formatAttributeValue($attribute, $key);
                            @endphp
                            @include('filament-activity-viewer::components.value',['value' => fn()=> $value, 'attributeName' => $key])
                        </td>
                    @endif
                </tr>
            @endforeach


            </tbody>
        </table>
    </div>

@endif

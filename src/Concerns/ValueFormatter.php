<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer\Concerns;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\View;

interface ValueFormatter
{
    public function format(mixed $value, string $attributeName, array $attributes, Activity $activity): string|Htmlable|View|null|int|float|bool|array;
}

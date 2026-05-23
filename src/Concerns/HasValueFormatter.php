<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer\Concerns;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\View;

interface HasValueFormatter
{
    public static function useFormatter(mixed $arguments = null): ValueFormatter;
}

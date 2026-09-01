<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer\Concerns;

interface HasValueFormatter
{
    public static function useFormatter(mixed $arguments = null): ValueFormatter;
}

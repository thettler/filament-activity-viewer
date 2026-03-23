<?php

namespace Thettler\FilamentActivityViewer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Thettler\FilamentActivityViewer\FilamentActivityViewer
 */
class FilamentActivityViewer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Thettler\FilamentActivityViewer\FilamentActivityViewer::class;
    }
}

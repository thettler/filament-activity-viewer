<?php

// config for Thettler/FilamentActivityViewer
use Illuminate\Database\Eloquent\Casts\AsEnumArrayObject;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Thettler\FilamentActivityViewer\Components\CreateActivity;
use Thettler\FilamentActivityViewer\Components\DeletedActivity;
use Thettler\FilamentActivityViewer\Components\RestoreActivity;
use Thettler\FilamentActivityViewer\Components\UpdateActivity;
use Thettler\FilamentActivityViewer\Formatters\AsEnumCollectionFormatter;

return [
    'events' => [
        'deleted' => DeletedActivity::class,
        'updated' => UpdateActivity::class,
        'created' => CreateActivity::class,
        'restored' => RestoreActivity::class,
    ],
    'origin_enum' => null,
    'console_origin' => null,
    'formatters' => [
        AsEnumCollection::class => AsEnumCollectionFormatter::class,
        AsEnumArrayObject::class => AsEnumCollectionFormatter::class,
    ],
];

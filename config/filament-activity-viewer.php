<?php

// config for Thettler/FilamentActivityViewer
use Thettler\FilamentActivityViewer\Components\DefaultActivity;

return [
    "events" => [
        'deleted' => \Thettler\FilamentActivityViewer\Components\DeletedActivity::class,
        'updated' => \Thettler\FilamentActivityViewer\Components\UpdateActivity::class,
        'created' => \Thettler\FilamentActivityViewer\Components\CreateActivity::class,
        'restored' => \Thettler\FilamentActivityViewer\Components\RestoreActivity::class
    ],
    'origin_enum' => null,
    'console_origin' => null,
    'formatters' => [
        \Illuminate\Database\Eloquent\Casts\AsEnumCollection::class => \Thettler\FilamentActivityViewer\Formatters\AsEnumCollectionFormatter::class,
        \Illuminate\Database\Eloquent\Casts\AsEnumArrayObject::class => \Thettler\FilamentActivityViewer\Formatters\AsEnumCollectionFormatter::class,
    ]
];

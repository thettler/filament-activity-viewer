<?php

namespace Thettler\FilamentActivityViewer;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Thettler\FilamentActivityViewer\Pages\ListAllActivities;

class FilamentActivityViewerPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-activity-viewer';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                ListAllActivities::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}

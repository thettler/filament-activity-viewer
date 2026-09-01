<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Thettler\FilamentActivityViewer\Pages\ListAllActivities;
use UnitEnum;

class FilamentActivityViewerPlugin implements Plugin
{
    protected string | UnitEnum | null $navigationGroup = null;

    protected bool $showAllAcivitys = true;

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

    public function navigationGroup(string | UnitEnum | null $navigationGroup): static
    {
        $this->navigationGroup = $navigationGroup;

        return $this;
    }

    public function showshowAllAcivitys(bool $showAllAcivitys = true): static
    {
        $this->showAllAcivitys = $showAllAcivitys;

        return $this;
    }

    public function getNavigationGroup(): string | UnitEnum | null
    {
        return $this->navigationGroup;
    }

    public function getShowAllAcivitys(): bool
    {
        return $this->showAllAcivitys;
    }

    public function getId(): string
    {
        return 'filament-activity-viewer';
    }

    public function register(Panel $panel): void
    {
        if ($this->getShowAllAcivitys()) {
            $panel
                ->pages([
                    ListAllActivities::class,
                ]);
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }
}

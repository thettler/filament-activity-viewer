<?php

namespace Thettler\FilamentActivityViewer\Commands;

use Illuminate\Console\Command;

class FilamentActivityViewerCommand extends Command
{
    public $signature = 'filament-activity-viewer';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

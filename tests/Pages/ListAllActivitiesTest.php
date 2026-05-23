<?php

use Thettler\FilamentActivityViewer\Pages\ListAllActivities;

it('can load page', function () {
 \Pest\Livewire\livewire(ListAllActivities::class)->assertOk();
});

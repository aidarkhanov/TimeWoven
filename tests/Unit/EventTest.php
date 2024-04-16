<?php

namespace Tests\Unit;

use App\Models\Event;
use Carbon\Carbon;

it('calculates the duration correctly', function () {
    $start = Carbon::now();
    $end = Carbon::now()->addHours(5);

    $event = new Event(['start_time' => $start, 'end_time' => $end]);
    $duration = $event->duration;

    expect($duration)->toEqual(5);
});

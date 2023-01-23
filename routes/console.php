<?php

use App\Models\ShortLink;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



Artisan::command('shoutlinks:cleanup', function () {
    $this->info('Cleanup the unvisited short links ...');
    // Delete links that were not visited for the past 30 days.
    $deleted = ShortLink::where('created_at', '<', now()->subDays(30))->where('views', 0)->delete();
    $this->info("$deleted links has been deleted on ". now());
})->purpose('Cleanup the unvisited short links');

<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\TrackingScript;
use Illuminate\Support\Facades\Cache;

class TrackingScriptComposer
{
    /**
     * Bind tracking scripts data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Cache tracking scripts for 1 hour to avoid N+1 queries
        $trackingScripts = Cache::remember('tracking_scripts_all', 3600, function () {
            return [
                'head' => TrackingScript::active()
                    ->byPosition('head')
                    ->ordered()
                    ->get(),
                'body_start' => TrackingScript::active()
                    ->byPosition('body_start')
                    ->ordered()
                    ->get(),
                'body_end' => TrackingScript::active()
                    ->byPosition('body_end')
                    ->ordered()
                    ->get(),
            ];
        });

        $view->with('trackingScripts', $trackingScripts);
    }
}
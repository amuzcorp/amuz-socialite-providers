<?php

namespace SocialiteProviders\Amuz;

use SocialiteProviders\Manager\SocialiteWasCalled;
use Illuminate\Support\ServiceProvider;

class AmuzSocialiteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app['events']->listen(SocialiteWasCalled::class, function (SocialiteWasCalled $event) {
            $event->extendSocialite('amuz', Provider::class);
        });
    }

    public function register()
    {
        //
    }
}

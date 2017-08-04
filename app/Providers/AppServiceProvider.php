<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.debug')) {
            $this->app->register('VIACreative\SudoSu\ServiceProvider');
        }

        $this->registerServices();

        $this->registerViewComposers();
    }

    /**
     * Bind the App services into the container.
     *
     * @return void
     */
    protected function registerServices()
    {
        $services = [
            'Song', 'Ktv', 'Singer', 'ContentOwner', 'KtvReport', 'ContentOwnerReport'
        ];

        foreach ($services as $service) {
            $this->app->bindIf(
                'App\\Contracts\\Repositories\\'.$service.'Repository',
                'App\\Repositories\\'.$service.'Repository'
            );
        }
    }

    /**
     * Register the App View Composers.
     *
     * @return void
     */
    protected function registerViewComposers()
    {
        $viewComposers = [
            //
        ];

        foreach ($viewComposers as $key => $value) {
            view()->composer($value, $key);
        }
    }
}

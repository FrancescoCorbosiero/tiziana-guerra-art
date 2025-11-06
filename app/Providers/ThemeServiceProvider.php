<?php

namespace App\Providers;

use Roots\Acorn\Sage\SageServiceProvider;
use App\Services\DesignSystemService;
use App\Services\PerformanceService;
use App\Services\SeoService;
use App\Services\I18nService;
use App\Services\AssetService;
use App\ViewComposers\GlobalComposer;

class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        // Register services as singletons
        $this->app->singleton(DesignSystemService::class, function ($app) {
            return new DesignSystemService();
        });

        $this->app->singleton(PerformanceService::class, function ($app) {
            return new PerformanceService();
        });

        $this->app->singleton(SeoService::class, function ($app) {
            return new SeoService();
        });

        $this->app->singleton(I18nService::class, function ($app) {
            return new I18nService();
        });

        $this->app->singleton(AssetService::class, function ($app) {
            return new AssetService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Register view composers (needed for both admin and frontend)
        $this->app->make('view')->composer('*', GlobalComposer::class);

        // Only initialize frontend optimizations when NOT in admin
        if (!is_admin()) {
            $this->bootFrontendServices();
        }
    }

    /**
     * Boot frontend-only services
     *
     * @return void
     */
    protected function bootFrontendServices()
    {
        // Initialize performance optimizations
        $performance = $this->app->make(PerformanceService::class);
        $performance->setupLazyLoading();
        $performance->setupWebVitals();

        // Initialize asset optimizations
        $asset = $this->app->make(AssetService::class);
        $asset->disableEmojis();

        // Add defer to scripts (frontend only)
        add_filter('script_loader_tag', function ($tag, $handle, $src) use ($asset) {
            return $asset->deferScript($tag, $handle, $src);
        }, 10, 3);
    }
}

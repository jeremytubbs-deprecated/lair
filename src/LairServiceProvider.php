<?php

namespace Jeremytubbs\Lair;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class LairServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Lair $lair
     */
    public function boot(Lair $lair)
    {
        // load routes
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        // load middleware
        $this->app['router']->middleware('roles', \Jeremytubbs\Lair\Http\Middleware\CheckRoles::class);
        $this->app['router']->middleware('permissions', \Jeremytubbs\Lair\Http\Middleware\CheckPermissions::class);
        $this->app['router']->middleware('owns', \Jeremytubbs\Lair\Http\Middleware\CheckOwnership::class);

        // create migrations
        if (!class_exists('CreateLairTables')) {
            // Publish the migration
            $this->publishes([
                __DIR__.'/../database/migrations/create_lair_tables.php' => $this->app->basePath().'/'.'database/migrations/2014_10_12_000000_create_lair_tables.php',
            ], 'migrations');
        }

        $lair->registerPermissions();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerBladeExtensions();

        // load views
        $this->loadViewsFrom(__DIR__.'/../resources/views/lair', 'lair');

        // publish auth views
        $this->publishes([
            __DIR__.'/../resources/views/auth' => base_path('resources/views/auth'),
        ]);
    }

    /**
     * Register the blade extensions.
     */
    protected function registerBladeExtensions()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $bladeCompiler->directive('role', function ($role) {
                return "<?php if(auth()->check() && auth()->user()->hasRole({$role})): ?>";
            });
            $bladeCompiler->directive('endrole', function () {
                return '<?php endif; ?>';
            });

            $bladeCompiler->directive('owner', function ($id) {
                return "<?php if(auth()->check() && auth()->user()->isOwner({$id})): ?>";
            });
            $bladeCompiler->directive('endOwner', function () {
                return '<?php endif; ?>';
            });
        });
    }
}

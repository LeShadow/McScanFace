<?php
/**
 * Created by PhpStorm.
 * User: sebastiaan
 * Date: 28/11/16
 * Time: 19:52
 */

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            'layouts.overall_header', 'App\Http\ViewComposers\TemplateComposer'
        );

        View::composer(
            'layouts.overall_menu', 'App\Http\ViewComposers\TemplateComposer'
        );

        View::composer(
            'layouts.overall_footer', 'App\Http\ViewComposers\TemplateComposer'
        );

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

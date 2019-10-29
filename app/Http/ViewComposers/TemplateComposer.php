<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
//use App\Models\ProjectConfig;

class TemplateComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        //$this->users = $users;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        //$site_config_data = ProjectConfig::all();

        //for($i=0; $i<$site_config_data->count(); $i++)
        //{
        //    $site_config[$site_config_data[$i]['key']] = $site_config_data[$i]['value'];
        //}

        #dd($site_config);

        $css_styles = [
            'css/sticky-footer-navbar.css',
            'css/slate/bootstrap.min.css',
            'css/offcanvas.css',
        ];

        $javascript_files = [
        ];

        $template_data = [];
        //$template_data['config'] = $site_config;
        $template_data['css'] = $css_styles;
        $template_data['js'] = $javascript_files;

        $view->with('template_data', $template_data);
    }
}

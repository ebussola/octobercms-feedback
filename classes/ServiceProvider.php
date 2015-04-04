<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 01/04/15
 * Time: 22:08
 */

namespace Ebussola\Feedback\Classes;


use Ebussola\Feedback\Models\Settings;
use Firebase\FirebaseLib;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ebussola.feedback::firebase', function($app) {
            return new FirebaseLib(Settings::get('url'), Settings::get('token'));
        });
    }

}
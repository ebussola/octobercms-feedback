<?php namespace eBussola\Feedback\Controllers;

use Backend\Classes\Controller;
use System\Classes\SettingsManager;

/**
 * channels Back-end Controller
 */
class Channels extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        \BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('eBussola.Feedback', 'channels');
    }
}
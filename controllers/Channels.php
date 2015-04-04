<?php namespace Ebussola\Feedback\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

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

        BackendMenu::setContext('Ebussola.Feedback', 'feedback', 'channels');
    }
}
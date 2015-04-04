<?php namespace Ebussola\Feedback;

use Illuminate\Support\Facades\Lang;
use System\Classes\PluginBase;
use App;

/**
 * feedback Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Feedback',
            'description' => 'An easy feedback component for your site.',
            'author'      => 'eBussola',
            'icon'        => 'icon-comments-o'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register()
    {
        App::register('\Ebussola\Feedback\Classes\ServiceProvider');
    }

    public function registerComponents()
    {
        return [
            '\eBussola\Feedback\Components\Feedback' => 'feedback'
        ];
    }

    /**
     * Registers any mail templates implemented by this plugin.
     * The templates must be returned in the following format:
     * ['acme.blog::mail.welcome' => 'This is a description of the welcome template'],
     * ['acme.blog::mail.forgot_password' => 'This is a description of the forgot password template'],
     */
    public function registerMailTemplates()
    {
        return [
            'ebussola.feedback::mail.feedback' => Lang::get('ebussola.feedback::lang.mail_template.description')
        ];
    }

    public function registerNavigation()
    {
        return [
            'feedback' => [
                'label'       => 'Feedback',
                'url'         => \Backend::url('ebussola/feedback/feedbacks'),
                'icon'        => 'icon-comments-o',
                'permissions' => ['ebussola.feedback.*'],

                'sideMenu' => [
                    'feedbacks' => [
                        'label'       => 'Inbox',
                        'icon'        => 'icon-inbox',
                        'url'         => \Backend::url('ebussola/feedback/feedbacks'),
                        'permissions' => ['ebussola.feedback.list'],
                    ],
                    'archived' => [
                        'label'       => 'Archived',
                        'icon'        => 'icon-archive',
                        'url'         => \Backend::url('ebussola/feedback/feedbacks/archived'),
                        'permissions' => ['ebussola.feedback.archived']
                    ],
                ]

            ]
        ];
    }

    public function registerSettings()
    {
        return [
            'channels' => [
                'label' => 'Channels',
                'description' => 'Manage Channels',
                'category' => 'Feedback',
                'icon' => 'icon-arrows',
                'url' => \Backend::url('ebussola/feedback/channels'),
                'order' => 500,
                'keywords' => 'feedback channel'
            ],
            'firebase' => [
                'label'       => 'Firebase',
                'description' => 'Settings for Firebase connection',
                'category'    => 'Feedback',
                'icon'        => 'icon-database',
                'class'       => '\Ebussola\Feedback\Models\Settings',
                'order'       => 500,
                'keywords'    => 'feedback firebase'
            ]
        ];
    }


}
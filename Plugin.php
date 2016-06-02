<?php namespace eBussola\Feedback;

use System\Classes\PluginBase;

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
            'name'        => 'ebussola.feedback::lang.plugin.name',
            'description' => 'ebussola.feedback::lang.plugin.description',
            'author'      => 'eBussola',
            'icon'        => 'icon-comments-o'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register()
    {
        \Validator::extend("emails", function($attribute, $value, $parameters) {
            $rules = [
                'email' => 'required|email',
            ];

            if (!is_array($value)) {
                $emails = explode(',', $value);
            }
            else {
                $emails = [$value];
            }

            foreach ($emails as $email) {
                $data = [
                    'email' => trim($email)
                ];
                $validator = \Validator::make($data, $rules);
                if ($validator->fails()) {
                    return false;
                }
            }

            return true;
        });
    }

    public function registerComponents()
    {
        return [
            '\eBussola\Feedback\Components\Feedback' => 'feedback'
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     */
    public function registerPermissions()
    {
        return [
            'ebussola.feedback.manage' => ['label' => 'ebussola.feedback::lang.permissions.feedback.manage', 'tab' => 'cms::lang.permissions.name'],
            'ebussola.feedback.settings.channel' => ['label' => 'ebussola.feedback::lang.permissions.settings.channel', 'tab' => 'system::lang.permissions.name']
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
            'ebussola.feedback::base-email' => \Lang::get('ebussola.feedback::lang.mail_template.description')
        ];
    }

    public function registerNavigation()
    {
        return [
            'feedback' => [
                'label'       => 'ebussola.feedback::lang.plugin.name',
                'url'         => \Backend::url('ebussola/feedback/feedbacks'),
                'icon'        => 'icon-comments-o',
                'permissions' => ['ebussola.feedback.manage'],

                'sideMenu' => [
                    'feedbacks' => [
                        'label'       => 'ebussola.feedback::lang.navigation.menu.side.feedbacks',
                        'icon'        => 'icon-inbox',
                        'url'         => \Backend::url('ebussola/feedback/feedbacks'),
                        'permissions' => ['ebussola.feedback.manage'],
                    ],
                    'archived' => [
                        'label'       => 'ebussola.feedback::lang.navigation.menu.side.archived',
                        'icon'        => 'icon-archive',
                        'url'         => \Backend::url('ebussola/feedback/feedbacks/archived'),
                        'permissions' => ['ebussola.feedback.manage']
                    ],
                ]

            ]
        ];
    }

    public function registerSettings()
    {
        return [
            'channels' => [
                'label' => 'ebussola.feedback::lang.channel.many',
                'description' => 'ebussola.feedback::lang.navigation.menu.settings.channels.description',
                'category' => 'ebussola.feedback::lang.plugin.name',
                'icon' => 'icon-arrows',
                'url' => \Backend::url('ebussola/feedback/channels'),
                'order' => 500,
                'keywords' => 'feedback channel',
                'permissions' => ['ebussola.feedback.settings.channel']
            ]
        ];
    }


}

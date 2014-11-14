<?php namespace Ebussola\Feedback;

use Illuminate\Support\Facades\Lang;
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
            'name'        => 'Feedback',
            'description' => 'An easy feedback component for your site.',
            'author'      => 'eBussola',
            'icon'        => 'icon-comments-o'
        ];
    }

    public function registerComponents()
    {
        return [
            '\Ebussola\Feedback\Components\Feedback' => 'feedback'
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

}
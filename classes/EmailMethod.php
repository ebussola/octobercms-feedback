<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 28/06/15
 * Time: 10:22
 */

namespace eBussola\Feedback\Classes;


use Backend\Models\User;
use Backend\Widgets\Form;
use eBussola\Feedback\Controllers\Channels;
use eBussola\Feedback\Models\Channel;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class EmailMethod implements Method
{

    public function boot()
    {
        Channels::extendFormFields(function (Form $form, $model) {
            $form->addFields([
                    'method_data[email_destination]' => [
                        'label' => "ebussola.feedback::lang.channel.emailDestination",
                        'commentAbove' => "ebussola.feedback::lang.backend.settings.channel.emailDestinationComment",
                        'required' => true,
                        'trigger' => [
                            'action' => "show",
                            'field' => "method",
                            'condition' => "value[email]"
                        ]
                    ],
                    'method_data[subject]' => [
                        'label' => "Subject",
                        'required' => true,
                        'trigger' => [
                            'action' => "show",
                            'field' => "method",
                            'condition' => "value[email]"
                        ]
                    ],
                    'method_data[template]' => [
                        'type' => 'codeeditor',
                        'language' => 'twig',
                        'label' => "Template",
                        'commentAbove' => 'The variables available here are these on the form. If you are using the default component template, they are: name, email and message',
                        'required' => true,
                        'trigger' => [
                            'action' => "show",
                            'field' => "method",
                            'condition' => "value[email]"
                        ]
                    ]
                ]
            );
        });

        Channel::extend(function(Channel $model) {
            $model->rules['method_data.email_destination'] = "emails";
            $model->attributeNames['method_data.email_destination'] = 'ebussola.feedback::lang.channel.emailDestination';
        });
    }

    public function send($methodData, $data)
    {
        $sendTo = $methodData['email_destination'];
        if ($sendTo == null) {
            // find the first admin user on the system
            $sendTo = $this->findAdminEmail();
        }

        $loader = new \Twig_Loader_Array(array(
            'subject' => $methodData['subject'],
            'main' => $methodData['template']
        ));
        $twig = new \Twig_Environment($loader);

        $subject = $twig->render('subject', $data);
        Mail::queue('ebussola.feedback::base-email', ['content' => $twig->render('main', $data)], function (Message $message) use ($sendTo, $subject, $data) {
            $message->subject($subject);
            $message->to(array_map('trim', explode(',', $sendTo)));

            $replyTo = isset($data['email']) ? $data['email'] : null;
            $replyToName = isset($data['name']) ? $data['name'] : 'Guest';
            if ($replyTo) {
                $message->replyTo($replyTo, $replyToName);
            }
        });
    }

    /**
     * @return mixed
     * @throws \ErrorException
     */
    private function findAdminEmail()
    {
        $sendTo = false;

        $users = User::all();
        foreach ($users as $user) {
            if ($user->isSuperUser()) {
                $sendTo = $user->email;
                break;
            }
        }

        if ($sendTo === false) {
            throw new \ErrorException('None email registered neither exists an admin user on the system (!?)');
        }

        return $sendTo;
    }

}

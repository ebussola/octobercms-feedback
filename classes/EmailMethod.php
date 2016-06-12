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
                        'label' => "ebussola.feedback::lang.method.email.destination",
                        'commentAbove' => "ebussola.feedback::lang.method.email.destination_comment",
                        'required' => true,
                        'trigger' => [
                            'action' => "show",
                            'field' => "method",
                            'condition' => "value[email]"
                        ]
                    ],
                    'method_data[subject]' => [
                        'label' => "ebussola.feedback::lang.method.email.subject",
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
                        'label' => "ebussola.feedback::lang.method.email.template",
                        'commentAbove' => 'ebussola.feedback::lang.method.email.template_comment',
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

        $data['serverName'] = \Request::instance()->server('SERVER_NAME');
        $data['host'] = \Request::instance()->getSchemeAndHttpHost();

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

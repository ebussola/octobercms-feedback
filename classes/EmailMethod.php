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
                    ]
                ]
            );
        });

        Channel::extend(function(Channel $model) {
            $model->rules['method_data.email_destination'] = "email";
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

        // avoiding any octobercms incompatibility
        $cleanData = [];
        foreach ($data as $key => $value) {
            $cleanData['_' . $key] = $value;
        }
        unset($data);

        Mail::queue('ebussola.feedback::mail.feedback', $cleanData, function (Message $message) use ($sendTo) {
            $message->to($sendTo);
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
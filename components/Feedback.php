<?php namespace eBussola\Feedback\Components;

use Backend\Models\User;
use Cms\Classes\ComponentBase;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Feedback extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Feedback Component',
            'description' => 'The Feedback component'
        ];
    }

    public function defineProperties()
    {
        return [
            'send_to' => [
                'title' => Lang::get('ebussola.feedback::lang.component.send_to.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.send_to.description'),
                'type' => 'string',
                'placeholder' => Lang::get('ebussola.feedback::lang.component.send_to.placeholder')
            ]
        ];
    }

    public function onSend()
    {
        $data = post('feedback');
        $send_to = $this->property('send_to', false);

        /** @var \Illuminate\Validation\Validator $validator */
        $validate_data = $this->validateData();
        $validator = Validator::make($data, $validate_data['rules'], $validate_data['messages']);
        if ($validator->fails()) {
            return [
                'error' => [
                    'messages' => $validator->messages()
                ]
            ];
        }

        if ($send_to === false) {
            // find the first admin user on the system
            $send_to = $this->findAdminEmail();
        }

        // avoiding any octobercms incompatibility
        $clean_data = [];
        foreach ($data as $key => $value) {
            $clean_data['_'.$key] = $value;
        }
        unset($data);

        Mail::send('ebussola.feedback::mail.feedback', $clean_data, function(Message $message) use ($send_to) {
            $message->to($send_to);
        });

        return Lang::get('ebussola.feedback::lang.component.onSend.success');
    }

    protected function validateData()
    {
        return [
            'rules' => [
                'email' => 'email',
                'message' => 'required'
            ],

            'messages' => [
                'email.email' => Lang::get('ebussola.feedback::lang.component.onSend.error.email.email'),
                'message.required' => Lang::get('ebussola.feedback::lang.component.onSend.error.message.required')
            ]
        ];
    }

    /**
     * @return mixed
     * @throws \ErrorException
     */
    private function findAdminEmail()
    {
        $send_to = false;

        $users = User::all();
        foreach ($users as $user) {
            if ($user->isSuperUser()) {
                $send_to = $user->email;
                break;
            }
        }

        if ($send_to === false) {
            throw new \ErrorException('None email registered neither exists an admin user on the system (!?)');
        }

        return $send_to;
    }

}
<?php namespace eBussola\Feedback\Components;

use Backend\Models\User;
use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use October\Rain\Exception\AjaxException;

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
//            'method' => [
//                'title' => 'Send using:',
//                'description' => '',
//                'type' => 'dropdown',
//                'options' => [
//                    'email' => 'Email',
//                    'zapier' => 'Zapier through Firebase'
//                ]
//            ],
            'sendTo' => [
                'title' => Lang::get('ebussola.feedback::lang.component.send_to.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.send_to.description'),
                'type' => 'string',
                'placeholder' => Lang::get('ebussola.feedback::lang.component.send_to.placeholder')
            ],

            'actionAfterSend' => [
                'title' => 'Action after send',
                'description' => 'lorem',
                'type' => 'dropdown',
                'options' => [
                    'redirect' => 'Redirect',
                    'javascript_alert' => 'Javascript Alert',
                    'custom_javascript' => 'Custom Javascript'
                ]
            ],
            'actionAfterSendRedirect' => [
                'title' => 'Redirect To',
                'description' => '',
                'type' => 'dropdown',
                'group' => 'After send actions'
            ],
            'actionAfterSendAlert' => [
                'title' => 'Alert message',
                'description' => '',
                'type' => 'string',
                'group' => 'After send actions'
            ],
            'actionAfterSendCustomJs' => [
                'title' => 'Custom Javascript',
                'description' => '',
                'type' => 'string',
                'group' => 'After send actions'
            ],

            'actionOnError' => [
                'title' => 'Action on Error',
                'description' => 'lorem',
                'type' => 'dropdown',
                'options' => [
                    'javascript_alert' => 'Javascript Alert',
                    'custom_javascript' => 'Custom Javascript'
                ],
                'default' => 'javascript_alert'
            ],
            'actionOnErrorCustomJs' => [
                'title' => 'Custom Javascript',
                'description' => '',
                'type' => 'string',
                'group' => 'After on Error'
            ]
        ];
    }

    public function onSend()
    {
        $data = post('feedback');
        $sendTo = $this->property('sendTo', false);

        /** @var \Illuminate\Validation\Validator $validator */
        $validateData = $this->validateData();
        $validator = Validator::make($data, $validateData['rules'], $validateData['messages']);
        if ($validator->fails()) {
            switch ($this->property('actionOnError')) {
                case 'javascript_alert' :
                    throw new AjaxException(json_encode([
                        'javascriptAlert' => $validator->messages()
                    ]));
                    break;

                case 'custom_javascript' :
                    throw new AjaxException(json_encode([
                        'customJavascript' => [
                            'messages' => $validator->messages(),
                            'script' => $this->property('actionOnErrorCustomJs')
                        ]
                    ]));
                    break;
            }
        }

        if ($sendTo === false) {
            // find the first admin user on the system
            $sendTo = $this->findAdminEmail();
        }

        // avoiding any octobercms incompatibility
        $cleanData = [];
        foreach ($data as $key => $value) {
            $cleanData['_'.$key] = $value;
        }
        unset($data);

        Mail::queue('ebussola.feedback::mail.feedback', $cleanData, function(Message $message) use ($sendTo) {
            $message->to($sendTo);
        });

        // Action after send
        switch ($this->property('actionAfterSend')) {
            case 'redirect' :
                return redirect(url($this->property('actionAfterSendRedirect')));

            case 'javascript_alert' :
                return ['javascriptAlert' => $this->property('actionAfterSendAlert', Lang::get('ebussola.feedback::lang.component.onSend.success'))];

            case 'custom_javascript' :
                return ['customJavascript' => $this->property('actionAfterSendCustomJs')];
                break;
        }
    }

    public function getActionAfterSendRedirectOptions()
    {
        return Page::sortBy('baseFileName')->lists('fileName', 'url');
    }

    public function getActionOnErrorRedirectOptions()
    {
        return Page::sortBy('baseFileName')->lists('fileName', 'url');
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
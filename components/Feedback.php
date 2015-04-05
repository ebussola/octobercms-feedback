<?php namespace eBussola\Feedback\Components;

use Backend\Models\User;
use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Ebussola\Feedback\Models\Channel;
use Firebase\FirebaseLib;
use Illuminate\Mail\Message;
use Lang;
use Mail;
use Validator;
use October\Rain\Exception\AjaxException;
use App;

class Feedback extends ComponentBase
{

    /**
     * @var Channel
     */
    public $channel;

    public function componentDetails()
    {
        return [
            'name'        => Lang::get('ebussola.feedback::lang.component.feedback.name'),
            'description' => Lang::get('ebussola.feedback::lang.component.feedback.description')
        ];
    }

    public function defineProperties()
    {
        $properties = [
            'channelCode' => [
                'title' => Lang::get('ebussola.feedback::lang.component.feedback.channelCode.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.feedback.channelCode.description'),
                'type' => 'dropdown',
                'required' => true
            ]
        ];

        return array_merge($properties, $this->defineJsProperties());
    }

    private function defineJsProperties()
    {
        return [
            'actionAfterSend' => [
                'title' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSend.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSend.description'),
                'type' => 'dropdown',
                'options' => [
                    'redirect' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSend.options.redirect'),
                    'javascript_alert' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSend.options.javascript_alert'),
                    'custom_javascript' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSend.options.custom_javascript')
                ]
            ],
            'actionAfterSendRedirect' => [
                'title' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSendRedirect.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSendRedirect.description'),
                'type' => 'dropdown',
                'group' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSend.groupName')
            ],
            'actionAfterSendAlert' => [
                'title' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSendAlert.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSendAlert.description'),
                'type' => 'string',
                'group' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSend.groupName')
            ],
            'actionAfterSendCustomJs' => [
                'title' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSendCustomJs.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSendCustomJs.description'),
                'type' => 'string',
                'group' => Lang::get('ebussola.feedback::lang.component.feedback.actionAfterSend.groupName')
            ],

            'actionOnError' => [
                'title' => Lang::get('ebussola.feedback::lang.component.feedback.actionOnError.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.feedback.actionOnError.description'),
                'type' => 'dropdown',
                'options' => [
                    'javascript_alert' => Lang::get('ebussola.feedback::lang.component.feedback.actionOnError.options.javascript_alert'),
                    'custom_javascript' => Lang::get('ebussola.feedback::lang.component.feedback.actionOnError.options.custom_javascript')
                ],
                'default' => 'javascript_alert'
            ],
            'actionOnErrorCustomJs' => [
                'title' => Lang::get('ebussola.feedback::lang.component.feedback.actionOnErrorCustomJs.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.feedback.actionOnErrorCustomJs.description'),
                'type' => 'string',
                'group' => Lang::get('ebussola.feedback::lang.component.feedback.actionOnError.groupName')
            ]
        ];
    }

    public function onSend()
    {
        $data = post('feedback');
        $channel = Channel::getByCode($this->property('channelCode'));

        // Error Handling
        $validateData = $this->validateData();
        /** @var \Illuminate\Validation\Validator $validator */
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

        switch ($channel->method)
        {
            case 'email' :
                $this->sendByEmail($channel->email_destination, $data);
                break;

            case 'firebase' :
                $this->sendByFirebase($channel->firebase_path, $data);
                break;

        }

        if (!$channel->prevent_save_database) {
            $feedback = new \Ebussola\Feedback\Models\Feedback($data);
            $feedback->save();
        }

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

    public function onRun()
    {
        $this->channel = Channel::getByCode($this->property('channelCode'));
    }

    public function getActionAfterSendRedirectOptions()
    {
        return Page::sortBy('baseFileName')->lists('fileName', 'url');
    }

    public function getActionOnErrorRedirectOptions()
    {
        return Page::sortBy('baseFileName')->lists('fileName', 'url');
    }

    public function getChannelCodeOptions()
    {
        return Channel::all()->lists('name', 'code');
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

    /**
     * @param $sendTo
     * @param $data
     * @throws \ErrorException
     */
    protected function sendByEmail($sendTo, $data)
    {
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
     * @param $data
     */
    protected function sendByFirebase($path, $data)
    {
        /** @var FirebaseLib $firebase */
        $firebase = App::make('ebussola.feedback::firebase');

        $firebase->push($path, $data);
    }

}
<?php namespace eBussola\Feedback\Components;

use Backend\Models\User;
use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Ebussola\Feedback\Models\Channel;
use Firebase\FirebaseLib;
use Illuminate\Mail\Message;
use Lang;
use Mail;
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
        return [
            'channelCode' => [
                'title' => Lang::get('ebussola.feedback::lang.component.feedback.channelCode.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.feedback.channelCode.description'),
                'type' => 'dropdown',
                'required' => true
            ],
            'successMessage' => [
                'title' => Lang::get('ebussola.feedback::lang.component.feedback.successMessage.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.feedback.successMessage.description')
            ],
            'redirectTo' => [
                'title' => Lang::get('ebussola.feedback::lang.component.feedback.redirectTo.title'),
                'description' => Lang::get('ebussola.feedback::lang.component.feedback.redirectTo.description'),
                'type' => 'dropdown',
                'default' => 0
            ]
        ];
    }

    /**
     * @throws \October\Rain\Database\ModelException
     */
    public function onSend()
    {
        $data = post('feedback');
        $channel = Channel::getByCode($this->property('channelCode'));
        $feedback = new \Ebussola\Feedback\Models\Feedback($data);

        $feedback->validate();

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
            $feedback->save();
        }

        \Flash::success($this->property('successMessage', Lang::get('ebussola.feedback::lang.component.onSend.success')));
        if ($this->property('redirectTo', false)) {
            return redirect(url($this->property('redirectTo')));
        }
    }

    public function onRun()
    {
        $this->channel = Channel::getByCode($this->property('channelCode'));
    }

    public function getRedirectToOptions()
    {
        return array_merge([0 => '- none -'], Page::sortBy('baseFileName')->lists('fileName', 'url'));
    }

    public function getChannelCodeOptions()
    {
        return Channel::all()->lists('name', 'code');
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
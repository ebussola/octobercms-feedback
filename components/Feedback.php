<?php namespace eBussola\Feedback\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use eBussola\Feedback\Models\Channel;
use Lang;
use October\Rain\Exception\AjaxException;

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
        try {
            $data = post('feedback');
            $channel = Channel::getByCode($this->property('channelCode'));
            $channel->send($data);

            $message = $this->property('successMessage', Lang::get('ebussola.feedback::lang.component.onSend.success'));
            \Flash::success($message);
            if ($this->property('redirectTo', false)) {
                return redirect(url($this->property('redirectTo')));
            }
            else {
                return $message;
            }
        }
        catch (\Exception $e) {
            \Flash::error($e->getMessage());
            throw new AjaxException($e->getMessage());
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

}
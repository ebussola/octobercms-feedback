<?php namespace eBussola\Feedback\Updates;

use eBussola\Feedback\Models\Channel;

class AddingTemplateFieldEmailMethod extends \Seeder
{
    public function run()
    {
        $defaultChannel = Channel::query()->where('code', 'default')->first();
        if ($defaultChannel) {
            $defaultChannel->method_data = ['template' => '<h1>You have just received a feedback from your site!</h1>
<p>
    Here is the contact information: {{ name }} &lt;<a href="mailto:{{ email }}">{{ email }}</a>&gt; <br>
</p>

<h2>The message:</h2>
<p>{{ message }}</p>'];

            $defaultChannel->save();
        }
    }
}
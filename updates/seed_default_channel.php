<?php namespace Ebussola\Feedback\Updates;

use Ebussola\Feedback\Models\Channel;

class SeedDefaultChannel extends \Seeder
{
    public function run()
    {
        Channel::create([
            'name' => "Default",
            'code' => "default",
            'method' => "email"
        ]);
    }
}
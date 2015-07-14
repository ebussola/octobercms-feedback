<?php namespace eBussola\Feedback\Updates;

use eBussola\Feedback\Models\Channel;

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
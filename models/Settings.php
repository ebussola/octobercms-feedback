<?php namespace eBussola\Feedback\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'ebussola_feedback_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
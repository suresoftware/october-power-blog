<?php namespace SureSoftware\PowerBlog\Models;

use Model;

/**
 * Settings Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'suresoftware_powerblog_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}

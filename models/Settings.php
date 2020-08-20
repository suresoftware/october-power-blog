<?php namespace SureSoftware\PowerBlog\Models;

use October\Rain\Database\Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'software_powerblog_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'enable_api' => ['boolean'],
        'blog_page_slug' => ['string'],
    ];
}

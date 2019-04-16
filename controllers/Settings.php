<?php namespace SureSoftware\PowerBlog\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use SureSoftware\PowerBlog\FormWidgets\Importer;

/**
 * Settings Back-end Controller
 */
class Settings extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        //Widget Setup
        $importer = new Importer($this);
        $importer->alias = 'importer';
        $importer->bindToController();

        BackendMenu::setContext('SureSoftware.PowerBlog', 'powerblog', 'settings');
    }
}

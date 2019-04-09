<?php namespace SureSoftware\PowerBlog\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use SureSoftware\PowerBlog\Models\Author;

/**
 * Authors Back-end Controller
 */
class Authors extends Controller
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

        BackendMenu::setContext('SureSoftware.PowerBlog', 'powerblog', 'authors');
    }
    public function index()
    {
        $this->vars['AuthorsTotal'] = Author::count();


        $this->asExtension('ListController')->index();
    }
}

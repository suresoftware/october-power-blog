<?php namespace SureSoftware\PowerBlog\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use SureSoftware\PowerBlog\FormWidgets\PowerConverter;

/**
 * Settings Back-end Controller
 */
class Converter extends Controller
{
    public function __construct()
    {
        parent::__construct();

        //Widget Setup
        $converter = new PowerConverter($this);
        $converter->alias = 'powerblog_converter';
        $converter->bindToController();

        $this->pageTitle = 'PowerBlog Converter';

        BackendMenu::setContext('SureSoftware.PowerBlog', 'powerblog', 'converter');
    }

    public function index()
    {
        //required for rendering
    }
}

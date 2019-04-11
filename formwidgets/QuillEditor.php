<?php namespace SureSoftware\PowerBlog\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Illuminate\Support\Facades\Log;

/**
 * QuillEditor Form Widget
 */
class QuillEditor extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'suresoftware_powerblog_quill_editor';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('quilleditor');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['delta'] = $this->model->powerblog_delta;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/quilleditor.css', 'SureSoftware.PowerBlog');
        $this->addJs('js/quilleditor.js', 'SureSoftware.PowerBlog');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        Log::info("value");
        Log::info($value);
        return $value;
    }
}

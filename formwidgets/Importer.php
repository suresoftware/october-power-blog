<?php namespace SureSoftware\PowerBlog\FormWidgets;

use Backend\Classes\WidgetBase;
use RainLab\Blog\Models\Post;
use Markdown;

/**
 * Importer Form Widget
 */
class Importer extends WidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'suresoftware_powerblog_importer';

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
        return $this->makePartial('importer');
    }

    public function prepareHtml()
    {
        $posts = Post::select('content', 'id')
            ->where('powerblog_delta', null)
            ->orWhere('powerblog_delta', '')
            ->get();
        foreach ($posts as $post) {
            {
                $post->content = Markdown::parseSafe($post->content);
            }
        }
        return $posts;
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['posts'] = $this->prepareHtml();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addJs('/plugins/suresoftware/powerblog/assets/js/importer.js');
        $this->addJs('https://cdn.quilljs.com/1.3.6/quill.js');
        $this->addCss('https://cdn.quilljs.com/1.3.6/quill.snow.css');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
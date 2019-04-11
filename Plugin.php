<?php namespace SureSoftware\PowerBlog;

use Backend;
use Rainlab\Blog\Models\Post;
use System\Classes\PluginBase;
use System\Classes\PluginManager;


/**
 * PowerBlog Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Power Blog',
            'description' => 'This plugin allows you to add an author component to blog posts. More features to come.',
            'author'      => 'Sure Software',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

        \Event::listen('backend.form.extendFields', function ($widget) {
            if (PluginManager::instance()->hasPlugin('RainLab.Blog') && $widget->model instanceof \RainLab\Blog\Models\Post) {
                $widget->addCss('/plugins/suresoftware/powerblog/assets/css/prettify.css');
                $widget->addCss('https://cdn.quilljs.com/1.3.6/quill.snow.css');
                $widget->addJs('/plugins/suresoftware/powerblog/assets/js/empower.js');
                $widget->addJs('https://cdn.quilljs.com/1.3.6/quill.js');

                $widget->addFields([
                    'powerblog_author' => [
                        'tab' => 'Power Blog',
                        'label' => 'Author',
                        'type' => 'relation',
                        'span' => 'left',
                    ],
                    'powerblog_delta' => [
                        'tab' => 'Power Blog',
                        'label' => 'Quill Editor',
                        'type' => '\SureSoftware\PowerBlog\FormWidgets\QuillEditor',
                        'stretch' => true,
                    ],
                ], 'secondary');
            }
        });
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        Post::extend(function($model) {
            $model->belongsTo['powerblog_author'] = ['SureSoftware\PowerBlog\Models\Author'];
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'SureSoftware\PowerBlog\Components\Author' => 'Author',
        ];
    }

    /**
     * Registers any back-end form widgets implemented in this plugin.
     *
     * @return array
     *
     */
    public function registerFormWidgets()
    {
        return [
            'SureSoftware\PowerBlog\FormWidgets\QuillEditor' => 'powerblog_quill_editor'
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
//        return []; // Remove this line to activate

        return [
            'suresoftware.powerblog.some_permission' => [
                'tab' => 'PowerBlog',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
//        return []; // Remove this line to activate

        return [
            'powerblog' => [
                'label'       => 'PowerBlog',
                'url'         => Backend::url('suresoftware/powerblog/authors'),
                'icon'        => 'icon-pencil',
                'permissions' => ['suresoftware.powerblog.*'],
                'order'       => 500,

                'sideMenu' => [
                    'new_author' => [
                        'label'       => 'New Author',
                        'icon'        => 'icon-plus',
                        'url'         => Backend::url('suresoftware/powerblog/authors/create'),
                        'permissions' => ['suresoftware.powerblog.*'],
                    ],

                    'authors' => [
                        'label'       => 'Authors',
                        'icon'        => 'icon-users',
                        'url'         => Backend::url('suresoftware/powerblog/authors'),
                        'permissions' => ['suresoftware.powerblog.*'],
                    ]
                ]
            ]
        ];
    }
}

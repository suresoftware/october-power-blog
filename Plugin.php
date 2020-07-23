<?php namespace SureSoftware\PowerBlog;

use Backend;
use Rainlab\Blog\Models\Post;
use System\Classes\PluginBase;
use System\Classes\PluginManager;
use System\Classes\SettingsManager;


/**
 * PowerBlog Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = ['RainLab.Blog'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Power Blog',
            'description' => 'This blog plugin is built with Quill for an enhanced writing experience. More features to come.',
            'author' => 'Sure Software',
            'icon' => 'icon-leaf'
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
        // Checks for empty powerblog_deltas (unconverted posts) and removes access to Blog until conversion is complete.
        $posts = Post::select()->where('powerblog_delta', null)->orWhere('powerblog_delta', '')->get();
        if (count($posts) > 0) {
            \Event::listen('backend.menu.extendItems', function ($manager) {
                $manager->removeMainMenuItem('RainLab.Blog', 'blog');
            });
            \Flash::warning('You must convert your posts into Power Blog posts in order to edit and access your posts.');
        }

        Post::extend(function ($model) {
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
            'SureSoftware\PowerBlog\Components\AuthorsList' => 'AuthorsList',
            'SureSoftware\PowerBlog\Components\AuthorFullDetails' => 'AuthorFullDetails',
            'SureSoftware\PowerBlog\Components\Post' => 'Post',
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
            'SureSoftware\PowerBlog\FormWidgets\QuillEditor' => 'powerblog_quill_editor',
            'SureSoftware\PowerBlog\FormWidgets\PowerConverter' => 'powerblog_converter',
            'SureSoftware\PowerBlog\FormWidgets\AvatarUploader' => 'powerblog_avatar_uploader'
        ];
    }

    /**
     * Registers any back-end settings.
     *
     * @return array
     */

    public function registerSettings()
    {
        return [];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'powerblog' => [
                'label' => 'Power Blog',
                'url' => Backend::url('suresoftware/powerblog/authors'),
                'icon' => 'icon-pencil',
                'permissions' => ['suresoftware.powerblog.*'],
                'order' => 500,

                'sideMenu' => [
                    'new_author' => [
                        'label' => 'New Author',
                        'icon' => 'icon-plus',
                        'url' => Backend::url('suresoftware/powerblog/authors/create'),
                        'permissions' => ['suresoftware.powerblog.*'],
                    ],

                    'authors' => [
                        'label' => 'Authors',
                        'icon' => 'icon-users',
                        'url' => Backend::url('suresoftware/powerblog/authors'),
                        'permissions' => ['suresoftware.powerblog.*'],
                    ],
                    'converter' => [
                        'label' => 'Convert Posts',
                        'icon' => 'icon-cog',
                        'url' => Backend::url('suresoftware/powerblog/converter'),
                        'permissions' => ['suresoftware.powerblog.*'],
                    ]
                ]
            ]
        ];
    }
}

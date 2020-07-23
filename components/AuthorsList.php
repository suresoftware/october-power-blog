<?php namespace SureSoftware\PowerBlog\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Illuminate\Support\Facades\Log;
use Rainlab\Blog\Models\Post;
use SureSoftware\TeamDisplay\Components\TeamCards;
use SureSoftware\TeamDisplay\Models\Tag;
use SureSoftware\TeamDisplay\Models\TeamMember;

class AuthorsList extends ComponentBase
{
    public $author;

    public function onRun()
    {
        $this->addCss('./assets/authorslist/style.css', "1.0.0");
        $this->author = $this->getAuthors();
        $this->excerpt = $this->getExcerpt();
    }

    public function componentDetails()
    {
        return [
            'name' => 'Authors List',
            'description' => 'Lists all the authors and the link to their dedicated author page'
        ];
    }

    public function defineProperties()
    {
        return [
            'clickable' => [
                'title'             => 'Clickable',
                'description'       => 'Don\'t show the description on hover and click through to the member page',
                'type'              => 'checkbox',
                'default'           => 'false'
            ],
            'page' => [
                'title'             => 'Author Page',
                'description'       => 'Page to show the author on',
                'type'              => 'dropdown',
                'default'           => '',
            ],
            'excerpt' => [
                'title'             => 'Excerpt Words',
                'description'       => 'Number of words to use in the Excerpt',
                'type'              => 'string',
                'default'           => '30',
            ],
        ];
    }

    public function getPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getAuthors()
    {
        $post = $this->page['post'];

        if (empty($post)) {
            return null;
        }

        $authors = \SureSoftware\PowerBlog\Models\Author::with('avatar')
            ->get();

        if ($authors) {
            return $authors;
        }

        return null;
    }

    public function getExcerpt(){
        $filters = $this->getProperties();

        if(!isset($filters['excerpt']) || empty($filters['excerpt']) || !is_numeric($filters['excerpt'])){
            return 30;
        }

        return intval($filters['excerpt']);
    }
}

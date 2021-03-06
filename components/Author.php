<?php namespace SureSoftware\PowerBlog\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Log;
use Rainlab\Blog\Models\Post;

class Author extends ComponentBase
{
    public $author;

    public function componentDetails()
    {
        return [
            'name' => 'Author Display',
            'description' => 'Adds an author module to the blog post.'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->author = $this->getAuthor();
    }

    public function getAuthor()
    {
        $post = $this->page['post'];

        if (empty($post)) {
            return null;
        }

        $author_id = $post->powerblog_author_id;
        $author = \SureSoftware\PowerBlog\Models\Author::with('avatar')->find($author_id);

        if ($author) {
            return $author;
        }

        return null;
    }
}

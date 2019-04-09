<?php namespace SureSoftware\PowerBlog\Components;

use Cms\Classes\ComponentBase;
use SureSoftware\PowerBlog\Models\Author as Author;

class Author extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Author Component',
            'description' => 'A simple component for adding authors to blog posts'
        ];
    }

    public function defineProperties()
    {
        return [
            'name' => 'name',
            'bio' => 'bio',
            'avatar' => 'avatar'
        ];
    }

    public function authors()
    {
        return Author::all();
    }
}

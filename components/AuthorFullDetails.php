<?php namespace SureSoftware\PowerBlog\Components;

use Cms\Classes\ComponentBase;

class AuthorFullDetails extends ComponentBase
{
    public $author;

    public function componentDetails()
    {
        return [
            'name' => 'Author Full Details',
            'description' => 'Component designed to have a dedicated page for a specific author'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'Author Slug',
                'description' => 'Slug of the author',
                'default' => '{{ :slug }}',
                'type' => 'string'
            ],
        ];
    }

    public function onRun()
    {
        $this->addCss('./assets/authorslist/style.css', "1.0.0");
        $this->author = $this->author();

        // integrate with PowerSEO
        if(isset($this->page->layout->components['SeoCmsPage'])){
            $author = $this->author();
            if($author == null){
                return $this->controller->run('404');
            }

            $this->page->layout->components['SeoCmsPage']->seo_title = $author->name;
            $this->page->layout->components['SeoCmsPage']->seo_description = substr($author->bio, 0, 150) . "...";
        }
    }

    /**
     * Get the specific member to show, filtering if necessary
     *
     * @return \SureSoftware\PowerBlog\Models\Author
     */
    public function author(){
        $filters = $this->getProperties();

        if(!isset($filters['slug']) || empty($filters['slug'])){
            return null;
        } else {
            return \SureSoftware\PowerBlog\Models\Author::with('avatar')
                ->where('slug', $filters['slug'])
                ->first();
        }
    }
}

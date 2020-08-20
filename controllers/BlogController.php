<?php namespace SureSoftware\PowerBlog\Controllers;

use Illuminate\Routing\Controller;
use Rainlab\Blog\Models\Post;
use Cms\Classes\Page as CmsPage;
use SureSoftware\PowerBlog\Models\Settings;

/**
 * Blog API Controller
 */
class BlogController extends Controller
{
    public function getPublished()
    {
        if (Settings::get('enable_api', false) != true) {
            return response()->json('Currently unavailable.', 404);
        }

        $posts = Post::isPublished()
            ->orderBy('published_at', 'DESC')
            ->limit(3)
            ->get();


        $baseUrl = Settings::get('blog_page_slug');
        if ($baseUrl !== '' && substr($baseUrl, -1) !== '/') {
            $baseUrl .= '/';
        }

        $blogPosts = [];
        if ($posts) {
            $posts->each(function ($post) use (&$blogPosts, $baseUrl) {
                $data = [
                    'title' => $post->title,
                    'excerpt' => $post->excerpt,
                    'published_at' => $post->published_at
                ];

                $data['slug'] = url($baseUrl . $post->slug);

                if ($post->featured_images->count() > 0) {
                    $data['feature_image'] = $post->featured_images->first()->path;
                }

                $blogPosts[] = $data;
            });
        }

        return response()->json($blogPosts, 200);
    }
}

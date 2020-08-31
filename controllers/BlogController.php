<?php namespace SureSoftware\PowerBlog\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Rainlab\Blog\Models\Post;
use SureSoftware\PowerBlog\Models\Settings;

/**
 * Blog API Controller
 */
class BlogController extends Controller
{
    /**
     * Return blog posts in published date order.
     * As part of API request can pass limit, default limit is 10.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPublished(Request $request)
    {
        // Check whether API is enabled.
        if (Settings::get('enable_api', false) != true) {
            return response()->json('Currently unavailable.', 404);
        }

        // Set number of posts to return. Default is 10
        $postLimit = $request->limit ? $request->limit : 10;

        $posts = Post::isPublished()
            ->orderBy('published_at', 'DESC')
            ->limit($postLimit)
            ->get();


        // Return blog page.
        $baseUrl = Settings::get('blog_page_slug');
        if ($baseUrl !== '' && substr($baseUrl, -1) !== '/') {
            $baseUrl .= '/';
        }

        $blogPosts = [];
        if ($posts) {
            // Create a new array based on post data.
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

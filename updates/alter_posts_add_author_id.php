<?php
/**
 * Created by PhpStorm.
 * User: emmacampbell
 * Date: 5/04/19
 * Time: 11:19 AM
 */

namespace SureSoftware\PowerBlog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AlterPostsAddAuthorId extends Migration
{

    public function up()
    {
        if (Schema::hasColumn('rainlab_blog_posts', 'powerblog_author_id')) {
            return;
        }

        Schema::table('rainlab_blog_posts', function($table)
        {
            $table->unsignedInteger('powerblog_author_id')->nullable();
        });
        Schema::table('rainlab_blog_posts', function($table)
        {
            $table->foreign('powerblog_author_id')->references('id')->on('suresoftware_powerblog_authors');
        });
    }

    public function down()
    {
        if (Schema::hasColumn('rainlab_blog_posts', 'powerblog_author_id')) {
            Schema::table('rainlab_blog_posts', function ($table) {
                $table->dropForeign('rainlab_blog_posts_powerblog_author_id_foreign');
                $table->dropColumn('powerblog_author_id');
            });
        }
    }

}

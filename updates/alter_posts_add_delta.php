<?php

namespace SureSoftware\PowerBlog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AlterPostsAddDelta extends Migration
{

    public function up()
    {
        if (Schema::hasColumn('rainlab_blog_posts', 'powerblog_delta')) {
            return;
        }

        Schema::table('rainlab_blog_posts', function($table)
        {
            $table->string('powerblog_delta')->nullable();
        });
    }

    public function down()
    {
        if (Schema::hasColumn('rainlab_blog_posts', 'powerblog_delta')) {
            Schema::table('rainlab_blog_posts', function ($table) {
                $table->dropColumn('powerblog_delta');
            });
        }
    }

}

<?php

namespace SureSoftware\PowerBlog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use SureSoftware\PowerBlog\Models\Author;

class AlterAuthorAddSlug extends Migration
{

    public function up()
    {
        if (Schema::hasColumn('suresoftware_powerblog_authors', 'slug')) {
            return;
        }

        Schema::table('suresoftware_powerblog_authors', function ($table) {
            $table->string('slug')->nullable();
        });

        // Existing authors get slugs generated for them
        $authors = Author::get();
        foreach($authors as $author){
            $author->touch();
        }
    }

    public function down()
    {
        if (!Schema::hasColumn('suresoftware_powerblog_authors', 'slug')) {
            return;
        }

        Schema::table('suresoftware_powerblog_authors', function ($table) {
            $table->dropColumn('slug');
        });
    }

}

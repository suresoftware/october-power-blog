<?php

namespace SureSoftware\PowerBlog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddAuthorLinkField extends Migration
{

    public function up()
    {
        if (Schema::hasColumn('suresoftware_powerblog_authors', 'link')) {
            return;
        }

        Schema::table('suresoftware_powerblog_authors', function ($table) {
            $table->text('link')->nullable();
        });
    }

    public function down()
    {
        if (!Schema::hasColumn('suresoftware_powerblog_authors', 'link')) {
            return;
        }

        Schema::table('suresoftware_powerblog_authors', function ($table) {
            $table->dropColumn('link');
        });
    }

}

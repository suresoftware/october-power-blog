<?php

namespace SureSoftware\PowerBlog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AlterAuthorBioLength extends Migration
{

    public function up()
    {
        if (!Schema::hasColumn('suresoftware_powerblog_authors', 'bio')) {
            return;
        }

        Schema::table('suresoftware_powerblog_authors', function ($table) {
            $table->longText('bio')->nullable()->change();
        });
    }

    public function down()
    {
        if (!Schema::hasColumn('suresoftware_powerblog_authors', 'bio')) {
            return;
        }

        Schema::table('suresoftware_powerblog_authors', function ($table) {
            $table->string('bio')->change();
        });
    }

}

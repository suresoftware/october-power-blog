<?php namespace SureSoftware\PowerBlog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAuthorsTable extends Migration
{
    public function up()
    {
        Schema::create('suresoftware_powerblog_authors', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('bio');
        });
    }

    public function down()
    {
        Schema::dropIfExists('suresoftware_powerblog_authors');
    }
}

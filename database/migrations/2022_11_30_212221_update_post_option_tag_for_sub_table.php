<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options_table', function($table) {
            $table->string('type',"255")->nullable()->default("default");
            $table->integer("options_id")->nullable();
        });

        Schema::table('post', function($table) {
            $table->string('type',"255")->nullable()->default("post");
            $table->integer("post_id")->nullable();
        });

        Schema::table('post', function($table) {
            $table->integer("tags_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

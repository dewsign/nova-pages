<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->active();
            $table->featured();
            $table->string('template')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->index();
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('image')->nullable();
            $table->text('summary')->nullable();
            $table->priority();
            $table->meta();
            $table->timestamps();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('pages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}

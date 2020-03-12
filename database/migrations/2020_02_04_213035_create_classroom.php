<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('subject')->nullable();
            $table->string('company')->nullable();
            $table->string('s3_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('classroom_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('classroom_course_id')->unsigned()->index()->on('classroom_courses');
            $table->bigInteger('user_id')->unsigned()->index()->on('users');
            $table->text('course_status')->nullable();
            $table->dateTime('completion_date')->nullable();
            $table->timestamps();
        });

        Schema::create('classroom_chapters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('classroom_course_id')->unsigned()->index()->on('classroom_courses')->onDelete('cascade');
            $table->string('chapter_name');
            $table->smallInteger('orderval')->default(0);
            $table->text('instructions')->nullable();
            $table->string('s3_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('classroom_archives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->on('users')->onDelete('cascade');
            $table->bigInteger('classroom_chapter_id')->unsigned()->index()->on('classroom_chapters')->onDelete('cascade');
            $table->bigInteger('classroom_course_id')->unsigned()->index()->on('classroom_courses')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('classroom_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('classroom_chapter_id')->unsigned()->index()->on('classroom_chapters')->onDelete('cascade');
            $table->string('section_name');
            $table->smallInteger('orderval')->unsigned()->default(0);
            $table->text('instructions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('classroom_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('classroom_section_id')->unsigned()->default(0)->index()->on('classroom_sections')->onDelete('cascade');
            $table->bigInteger('classroom_chapter_id')->unsigned()->index()->on('classroom_chapters')->onDelete('cascade');
            $table->text('question');
            $table->string('section');
            $table->smallInteger('orderval')->unsigned()->default(0);
            $table->string('question_type',20);
            $table->text('questions');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('classroom_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index()->on('users')->onDelete('cascade');
            $table->bigInteger('classroom_question_id')->unsigned()->index()->on('classroom_questions')->onDelete('cascade');
            $table->bigInteger('classroom_chapter_id')->unsigned()->default(0)->index()->on('classroom_chapters')->onDelete('cascade');
            $table->text('answer');
            $table->bigInteger('classroom_archive_id')->unsigned()->nullable()->index()->on('classroom_archives')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_answers');
        Schema::dropIfExists('classroom_questions');
        Schema::dropIfExists('classroom_sections');
        Schema::dropIfExists('classroom_archives');
        Schema::dropIfExists('classroom_chapters');
        Schema::dropIfExists('classroom_assignments');
        Schema::dropIfExists('classroom_courses');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('body');
            $table->date('due_date')->nullable(true);
            $table->string('attachment_path')->nullable(true);
            $table->boolean('complete')->default(false);
            $table->string('remind_executor_in', 20)->nullable(true);

            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('executor_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}

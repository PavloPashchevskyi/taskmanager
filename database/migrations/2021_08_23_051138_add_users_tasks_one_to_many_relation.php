<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersTasksOneToManyRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->index('creator_id');
            $table->index('executor_id');
            $table->foreign('creator_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('executor_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('executor_id');
            $table->dropIndex('executor_id');
            $table->dropForeign('creator_id');
            $table->dropIndex('creator_id');
        });
    }
}

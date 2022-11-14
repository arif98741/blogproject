<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('table_name');
            $table->string('row_id');
            $table->string('action_name');
            $table->string('activity');
            $table->string('ip');
            $table->string('user_agent');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
        });

        /**
         *
         * CREATE TABLE `activity_logs` (
         * `id` int(11) NOT NULL AUTO_INCREMENT,
         * `table_name` varchar(50) NOT NULL,
         * `row_id` varchar(11) DEFAULT NULL,
         * `action_name` varchar(100) DEFAULT NULL,
         * `activity` text NOT NULL,
         * `ip` varchar(15) DEFAULT NULL,
         * `user_agent` varchar(255) DEFAULT NULL,
         * `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
         * `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
         * PRIMARY KEY (`id`)
         * ) ENGINE=MyISAM AUTO_INCREMENT=544 DEFAULT CHARSET=latin1;
         * /*!40101 SET character_set_client = @saved_cs_client *
         */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}

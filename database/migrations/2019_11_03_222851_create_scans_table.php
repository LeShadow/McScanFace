<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->smallInteger('scan_status')->default(0); //0 = not started, 1 = busy, 2 = done
            $table->string('name');
            $table->string('output_format')->default('json');
            $table->string('ports')->nullable();
            $table->integer('top_ports')->nullable();
            $table->smallInteger('banners')->default(0);
            $table->integer('rate')->default(5000);
            $table->text('ip_ranges');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scans');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScanFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scan_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->integer('scan_id');
            $table->timestamps();

            $table->foreign('scan_id')
                ->references('id')
                ->on('scans')
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
        Schema::dropIfExists('scan_files');
    }
}

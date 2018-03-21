<?php

use App\Entity\Run;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRunsAndDataTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'runs',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('run_id');
                $table->integer('count_row')->default(0);
                $table->string('status')->default(Run::PENDING_STATUS);

                $table->timestamps();
            }
        );

        Schema::create(
            'data',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('project_tag')->nullable();
                $table->string('run_tag')->nullable();
                $table->string('name')->nullable();
                $table->text('name_url')->nullable();
                $table->string('dealer')->nullable();
                $table->text('dealer_url')->nullable();
                $table->string('price')->nullable();
                $table->string('car_image')->nullable();
                $table->text('car_image_url')->nullable();
                $table->string('mileage')->nullable();
                $table->string('gearbox')->nullable();
                $table->string('handdrive')->nullable();
                $table->string('details')->nullable();
                $table->string('details_url')->nullable();
                $table->string('phone')->nullable();
                $table->string('year')->nullable();
                $table->string('refcode')->nullable();
                $table->string('phone_url')->nullable();
                $table->text('description')->nullable();
                $table->string('location')->nullable();
                $table->string('vin')->nullable();
                $table->string('brand')->nullable();
                $table->string('model')->nullable();
                $table->string('dealer_website')->nullable();
                $table->string('dealer_website_url')->nullable();
                $table->text('field1')->nullable();
                $table->text('field2')->nullable();
                $table->text('field3')->nullable();
                $table->text('field4')->nullable();
                $table->text('field5')->nullable();
                $table->text('field6')->nullable();
                $table->text('field7')->nullable();
                $table->text('field8')->nullable();
                $table->text('field9')->nullable();
                $table->text('field10')->nullable();
                $table->text('field11')->nullable();
                $table->text('field12')->nullable();

                $table->unsignedInteger('run_id');
                $table->foreign('run_id')
                      ->references('id')
                      ->on('runs')
                      ->onDelete('cascade');

                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('runs');
        Schema::dropIfExists('data');
    }
}

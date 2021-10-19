<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            // $table->id();
            $table->string('employeeID',255)->primary('employeeID');
            $table->string('lastName',255);
            $table->string('firstName',255);
            $table->string('email',255)->unique();
            $table->string('password',255);
            $table->string('image',255);
            $table->date('birthDay');
            $table->string('gender',255);
            $table->string('identityCard',255);
            $table->string('address',255);
            $table->string('phone',255);
            $table->integer('level')->default(7);
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
        Schema::dropIfExists('employees');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeIdInImportOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_orders', function (Blueprint $table) {
            $table->string('employeeID',255)->after('importOrderID');
            $table->foreign('employeeID')->references('employeeID')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_orders', function (Blueprint $table) {
            //
        });
    }
}

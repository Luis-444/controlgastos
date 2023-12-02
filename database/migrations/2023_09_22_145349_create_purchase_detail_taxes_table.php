<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_detail_taxes', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->unsignedBigInteger('purchase_detail_id')->nullable();
            $table->foreign('purchase_detail_id')->references('id')->on('purchase_details');
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->foreign('tax_id')->references('id')->on('taxes');
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
        Schema::dropIfExists('purchase_detail_taxes');
    }
};

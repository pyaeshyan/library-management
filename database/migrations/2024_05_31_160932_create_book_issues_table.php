<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_issues', function (Blueprint $table) {
            $table->id();
            $table->integer('book_id');
            $table->integer('category_id');
            $table->integer('frontend_use_id');
            $table->date('to_return_date');
            $table->date('returned_date')->nullable();
            $table->integer('overdue_days')->default();
            $table->enum( 'status', ['issued', 'returned'])->default('issued');
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
        Schema::dropIfExists('book_issues');
    }
}

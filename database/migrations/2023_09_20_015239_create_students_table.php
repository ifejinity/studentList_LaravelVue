<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id_number');
            $table->string('student_type', 191);
            $table->string('name', 191);
            $table->integer('age');
            $table->string('city', 191);
            $table->string('gender', 191)->nullable();
            $table->string('mobile_number', 12);
            $table->decimal('grades', 30, 15)->nullable();
            $table->string('email', 191);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->unique(array('id_number', 'name', 'mobile_number'), 'idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

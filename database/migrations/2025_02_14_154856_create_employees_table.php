<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete(); 
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->string('employee_type');
            $table->string('job_position');
            $table->date('birthday');
            $table->date('hire_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop the 'employees' table if it exists
        Schema::dropIfExists('employees');
    }
};

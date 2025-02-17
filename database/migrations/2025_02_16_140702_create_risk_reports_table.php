<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('risk_reports', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('risk_number')->unique(); 
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); 
            $table->string('type');
            $table->string('pn_number');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('segment');
            $table->string('frp_class');
            $table->decimal('applied_loan', 15, 2); 
            $table->date('date_rated');
            $table->decimal('score', 5, 2); 
            $table->string('risk');
            $table->text('risk_desc');
            $table->date('next_review_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_reports');
    }
};

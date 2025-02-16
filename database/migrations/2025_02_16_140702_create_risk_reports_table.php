<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('risk_reports', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('risk_number')->unique(); // Format: RISK_DDMMYYYY_0001
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // Foreign Key
            $table->string('type');
            $table->string('pn_number');
            $table->string('branch');
            $table->string('segment');
            $table->string('frp_class');
            $table->decimal('applied_load', 15, 2); // Handles large amounts with 2 decimal places
            $table->date('date_rated');
            $table->decimal('score', 5, 2); // Score can have decimals (e.g., 85.50)
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

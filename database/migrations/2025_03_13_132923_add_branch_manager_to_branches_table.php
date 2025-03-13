<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->foreignId('branch_manager_id')
                  ->nullable()
                  ->constrained('employees')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropForeign(['branch_manager_id']);
            $table->dropColumn('branch_manager_id');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->integer('receriver_id')->unsigned();
            $table->boolean('read')->default(0)->nullable();
            $table->string('type')->nullable();
            $table->integer('conversation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('receriver_id');
            $table->dropColumn('read');
            $table->dropColumn('type');
            $table->dropColumn('conversation_id');
        });
    }
};

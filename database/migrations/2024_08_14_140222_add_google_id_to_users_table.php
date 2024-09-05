<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table((new (config('google-signin.user_model')))->getTable(), function (Blueprint $table) {
            $table->string('google_id')->after('id')->nullable()->unique();
        });
    }

    public function down(): void
    {
        Schema::table((new (config('google-signin.user_model')))->getTable(), function (Blueprint $table) {
            $table->dropColumn('google_id');
        });
    }
};

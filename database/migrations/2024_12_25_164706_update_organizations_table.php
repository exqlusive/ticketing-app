<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
        });

        DB::table('organizations')->orderBy('id')->chunk(100, function ($organizations) {
            $existingSlugs = DB::table('organizations')->pluck('slug')->toArray();

            foreach ($organizations as $organization) {
                $slug = Str::slug($organization->name);
                $originalSlug = $slug;

                $count = 1;
                while (in_array($slug, $existingSlugs)) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }

                DB::table('organizations')
                    ->where('id', $organization->id)
                    ->update(['slug' => $slug]);

                $existingSlugs[] = $slug;
            }
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->string('slug')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('email');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('postal_code');
            $table->dropColumn('country');
        });
    }
};

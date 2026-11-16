<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->string('role', 30)->default('editor')->after('password');
            $t->boolean('is_active')->default(true)->after('role');
            $t->timestamp('last_login_at')->nullable()->after('is_active');
        });
        // Akun yang sudah ada sebelum fitur peran dianggap Admin.
        DB::table('users')->update(['role' => 'admin']);

        Schema::table('posts', function (Blueprint $t) {
            $t->string('type', 20)->default('berita')->after('id')->index();
            $t->string('status', 20)->default('draft')->after('type')->index();
            $t->foreignId('author_id')->nullable()->after('status');
            $t->timestamp('submitted_at')->nullable();
            $t->foreignId('checked_by')->nullable();
            $t->timestamp('checked_at')->nullable();
            $t->foreignId('approved_by')->nullable();
            $t->timestamp('approved_at')->nullable();
            $t->foreignId('published_by')->nullable();
            $t->text('review_note')->nullable();
        });
        DB::table('posts')->where('is_published', true)->update(['status' => 'published']);
        Schema::table('posts', function (Blueprint $t) {
            $t->dropColumn('is_published');
        });

        Schema::create('agendas', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->date('starts_on');
            $t->date('ends_on')->nullable();
            $t->string('time_text', 80)->nullable();
            $t->string('location')->nullable();
            $t->text('description')->nullable();
            $t->foreignId('created_by')->nullable();
            $t->timestamps();
            $t->index('starts_on');
        });

        Schema::create('activity_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->index();
            $t->string('user_name')->default('Sistem');
            $t->string('role', 30)->nullable();
            $t->string('action', 30)->index();
            $t->text('description');
            $t->string('subject_type', 60)->nullable();
            $t->unsignedBigInteger('subject_id')->nullable();
            $t->string('ip', 45)->nullable();
            $t->timestamps();
            $t->index(['subject_type', 'subject_id']);
            $t->index('created_at');
        });

        Schema::create('visits', function (Blueprint $t) {
            $t->id();
            $t->date('visited_on');
            $t->string('visitor_hash', 40);
            $t->unsignedInteger('hits')->default(1);
            $t->unique(['visited_on', 'visitor_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('agendas');
        Schema::table('posts', function (Blueprint $t) {
            $t->boolean('is_published')->default(false);
        });
        DB::table('posts')->where('status', 'published')->update(['is_published' => true]);
        Schema::table('posts', function (Blueprint $t) {
            $t->dropColumn(['type', 'status', 'author_id', 'submitted_at', 'checked_by', 'checked_at', 'approved_by', 'approved_at', 'published_by', 'review_note']);
        });
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['role', 'is_active', 'last_login_at']);
        });
    }
};

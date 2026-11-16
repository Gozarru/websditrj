<?php

use App\Support\SiteMenu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('parent_id')->nullable()->index(); // null = menu utama; terisi = isi dropdown
            $t->string('label', 60);
            $t->string('link_type', 10)->default('page');    // page | url | none
            $t->string('page', 60)->nullable();              // kunci halaman situs, mis. "profil:sejarah"
            $t->string('url')->nullable();                   // alamat lain (https://... atau /alamat)
            $t->boolean('new_tab')->default(false);
            $t->boolean('is_visible')->default(true);
            $t->unsignedInteger('position')->default(0);
            $t->timestamps();
        });

        // Menu yang selama ini tampil di website menjadi isi awal, sehingga tampilan tidak berubah.
        SiteMenu::seedDefaults();
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};

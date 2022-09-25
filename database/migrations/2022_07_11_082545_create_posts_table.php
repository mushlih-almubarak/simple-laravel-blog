<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Membuat tabel 'posts' baru di mysqli
        Schema::create('posts', function (Blueprint $table) {
            // Isi tabel 'posts'
            $table->id();
            $table->string('title'); // title adalah keyword yang kita isikan sendiri
            $table->string('slug')->unique(); // unique() = jika ada data slug yang dikirimkan sama, maka tolak (gagalkan querynya) 
            $table->foreignId('category_id')->default(5); // 'category' 'id' harus sama namanya dengan yang ada di model category agar bisa terhubung
            $table->foreignId('user_id');
            $table->string('image')->nullable();
            $table->text('body');
            $table->text('excerpt');
            $table->string('created_at_ip_address');
            $table->string('created_at_country');
            $table->string('created_at_city');
            $table->string('status');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps(); // Kapan dibuat dan di update
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};

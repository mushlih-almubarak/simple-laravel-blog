<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Field-field ini tidak boleh diisi
    protected $guarded = ['id', 'updated_at', 'created_at'];
    // Sertakan (load) juga model 'author' dan 'category', agar nanti tidak perlu meng-query lagi berulang-ulang di 'foreach'nya
    protected $with = ['author', 'category'];
    protected $dates = ['deleted_at'];

    // Cari postingan sesuai: ('scope' adalah keyword wajib, dan 'by' adalah keyword yg kita buat sendiri)
    public function scopeBy($query, array $keyword)
    {
        // Cari berdasarkan keyword
        $query->when($keyword['cari'] ?? false, function ($query, $keyword) {
            return $query->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')->orWhere('body', 'like', '%' . $keyword . '%');
            });
        });

        // Tampilkan seluruh artikel sesuai dengan kategori
        $query->when($keyword['kategori'] ?? false, function ($query, $kategori) {
            return $query->whereHas('category', function ($query) use ($kategori) {
                $query->where('slug', $kategori);
            });
        });

        // Tampilkan seluruh artikel sesuai dengan author
        $query->when($keyword['penulis'] ?? false, function ($query, $penulis) {
            return $query->whereHas('author', function ($query) use ($penulis) {
                $query->where('username', $penulis);
            });
        });
    }

    // Menghubungkan model 'Blog' ke model 'Category'. Nama functionnnya harus sama dengan nama model yang ingin dihubungkan. 
    public function category()
    {
        // Setiap post hanya memiliki 1 kategori 
        return $this->belongsTo(Category::class);
    }

    // Jika nama functionnya ingin beda dengan nama yang di model yang ingin dihubungkannya, maka tambahkan parameter kedua yang isinya value dari foreignId yang bersangkutan.
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Default key bindingnya
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    // protected $with = ['categories'];

    public function scopeFilter($query, array $filters = null)
    {
        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas('categories', function ($query) use ($category) {
                $query->where('name', $category);
            });
        });

        $query->when($filters['favorite'] ?? false, function ($query, $favorite) {
            return $query->where('is_favorite', $favorite);
        });

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('content','like', '%' . $search . '%');
        });

        return $query;
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'note_category','note','category');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

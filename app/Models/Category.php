<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    // protected $with = ['notes'];

    public function scopeFilter($query, array $filters = null)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function notes(){
        return $this->belongsToMany(Note::class,'note_category','category','note');
    }
}

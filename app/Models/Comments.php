<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'comment',
    ];

    public function comments()
    {
        return $this->hasMany(Comments::class, 'comment_id');
    }

    public function childrenComments()
    {
        return $this->hasMany(Comments::class, 'comment_id')->with('comments');
    }
}

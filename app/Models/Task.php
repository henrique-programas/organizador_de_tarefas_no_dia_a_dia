<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'completed', 'user_id', 'type', 'priority'];

    public function user()
    {
        return $this->belongTo(User::class);
    }

}
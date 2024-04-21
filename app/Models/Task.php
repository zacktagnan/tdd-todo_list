<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed',
    ];

    public function createdAtWithFormat()
    {
        return $this->created_at->isoFormat('llll');
    }

    public function createdAtDiffForHumans()
    {
        return $this->created_at->diffForHumans();
    }
}

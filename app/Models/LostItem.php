<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    protected $fillable = [
        'name',
        'student_id',
        'item_name',
        'description',
        'contact_info',
        'location',
        'image',
        'reference_id',
        'date_lost', // <-- Add this line to allow mass assignment of date_lost
        'status',
        'found_at'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'description', 'company_capacity',  'working_hours', 'image', 'user_id','category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }
    public function category()
{
    return $this->belongsTo(Category::class);
}
}
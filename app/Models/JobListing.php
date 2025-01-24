<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'salary', 'location', 'working_hours', 'experience', 'job_title', 'company_id', 'category_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
	    'title', 'inn', 'description',
		'director', 'address', 'phone',
	];
	
    /**
     * Все комменты компании.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function comments() : HasMany
	{
		return $this->hasMany(Comment::class);
	}
}

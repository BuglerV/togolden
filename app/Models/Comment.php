<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    // use HasFactory;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
	    'user_id',
	    'company_id',
		'field',
	    'text',
	    'author',
	];
	
    /**
     * Комментируемая компания.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function company() : BelongsTo
	{
		return $this->belongsTo(Company::class);
	}
	
	public function getCreatedAttribute()
	{
		$carbon = new Carbon(new \DateTime($this->created_at), new \DateTimeZone('Europe/Moscow'));
		
		return $carbon->toDateTimeString();
	}
}

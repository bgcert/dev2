<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Likable;
use App\Traits\Commentable;
use Spatie\Activitylog\Traits\LogsActivity;

class Theme extends Model
{
	use Likable;
	use Commentable;
    use LogsActivity;
    
    protected $fillable = [
        'company_id', 'title', 'body',
    ];

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function events()
    {
    	return $this->hasMany('App\Event');
    }
}

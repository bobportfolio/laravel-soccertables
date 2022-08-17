<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

// class

class DirectiveEvents extends Eloquent 
{
	protected $table = 'directive_events';
	
	public function scopeOnDate($query,$league,$date)
    {
        return $query->whereRaw('event_date = ? and league_season_fk = ?', 
			array($date,$league))->get();
 	}
	
	public function scopeUpToDate($query,$league,$date)
    {
        return $query->whereRaw('event_date <= ? and league_season_fk = ?', 
			array($date,$league))->get();
 	}
 	
 	public function scopePreviousDate($query,$league,$date)
 	{
		$prev='null';
		$id = $query->whereRaw('event_date < ? and league_season_fk = ?',
			array($date,$league))->max('id');
		if(isset($id)) $prev = $query->find($id)->event_date;
		return $prev;
	}

 	public function scopeNextDate($query,$league,$date)
 	{
		$next = 'null';
		$id = $query->whereRaw('event_date > ? and league_season_fk = ?',
			array($date,$league))->min('id');
		if(isset($id)) $next = $query->find($id)->event_date;
		return $next;
	}

	public function team()
	{
		return $this->hasOne('App\Models\Teams','id','team_fk');
	}

	public function reason()
	{
		return $this->hasOne('App\Models\Directive','id','directive_fk');
	}

	public function referenceUrl()
	{
		return $this->hasOne('App\Models\Urls','id','reference_url_fk');
	}
}

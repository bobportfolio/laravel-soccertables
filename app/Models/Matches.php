<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

// class

class Matches extends Eloquent 
{
	protected $table = 'matches';
	
	public function scopeOnDate($query,$league,$matchdate)
    {
        return $query->whereRaw('match_date = ? and league_season_fk = ?', 
			array($matchdate,$league))->get();
 	}
	
	public function scopeUpToDate($query,$league,$matchdate)
    {
        return $query->whereRaw('match_date <= ? and league_season_fk = ?', 
			array($matchdate,$league))->get();
 	}
 	
 	public function scopePreviousDate($query,$league,$matchdate)
 	{
		$prev='null';
		$id = $query->whereRaw('match_date < ? and league_season_fk = ?',
			array($matchdate,$league))->max('id');
		if(isset($id)) $prev = $query->find($id)->match_date;
		return $prev;
	}

 	public function scopeNextDate($query,$league,$matchdate)
 	{
		$next = 'null';
		$id = $query->whereRaw('match_date > ? and league_season_fk = ?',
			array($matchdate,$league))->min('id');
		if(isset($id)) $next = $query->find($id)->match_date;
		return $next;
	}

	public function homeTeam()
	{
		return $this->hasOne('App\Models\Teams','id','home_team_fk');
	}

	public function awayTeam()
	{
		return $this->hasOne('App\Models\Teams','id','away_team_fk');
	}
}

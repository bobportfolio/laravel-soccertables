<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

// class

class LeaguePhases extends Eloquent 
{
	protected $table = 'league_phases';

	public function scopeOnDate($query,$league,$matchdate)
    {
        return $query->whereRaw('league_season_fk = ? and start_date <= ? and end_date >= ?', 
			array($league,$matchdate,$matchdate))->first();
 	}
}

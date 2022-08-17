<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

// class

class LeagueColours extends Eloquent 
{
	protected $table = 'league_colours';

	public function scopeGetColours($query,$league)
    {
		return $query->where('league_season_fk', '=', $league)->get();
  	}
}

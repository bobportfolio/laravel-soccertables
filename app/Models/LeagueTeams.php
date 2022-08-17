<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

// class

class LeagueTeams extends Eloquent 
{
	protected $table = 'league_teams';
	
	public function scopeGetTeam($query,$league,$id)
    {
		return $query->whereRaw('team_fk = ? and league_season_fk = ?', array($id,$league))->first();
  	}
	
	public function scopeTeams($query,$league)
    {
		return $query->where('league_season_fk', '=', $league)->get();
  	}

	public function team()
	{
		return $this->hasOne('App\Models\Teams','id','team_fk');
	}
}

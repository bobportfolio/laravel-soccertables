<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

// class

class LeagueSections extends Eloquent 
{
	protected $table = 'league_sections';

    public function scopeOnPhase($query,$phase_fk)
    {
        return $query->whereRaw('phase_fk = ?', array($phase_fk))->get();
 	}

	public function team()
	{
		return $this->hasOne('App\Models\Teams','id','team_fk');
	}
}

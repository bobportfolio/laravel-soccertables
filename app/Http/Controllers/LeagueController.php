<?php

namespace App\Http\Controllers;
use Cookie;
use Mail;
use Request;
use Response;
use Validator;
use App\Models\LeagueColours as LeagueColours;
use App\Models\LeagueSeason as LeagueSeason;
use App\Models\LeagueTeams as LeagueTeams;
use App\Models\Matches as Matches;
use App\Models\DirectiveEvents as DirectiveEvents;
use App\Models\LeaguePhases as LeaguePhases;
use App\Models\LeagueSections as LeagueSections;
use App\Models\TableSort as TableSort;
use App\Models\DBQuery as DBQuery;


class LeagueController extends Controller 
{
	public function home()
	{
		$cookie = Cookie::get('soccer-tables');
		if($cookie)
		{
			$cookie = json_decode($cookie,true);
			if(array_key_exists('date',$cookie))
			{
				$matchdate = $cookie['date'];
				$league = $cookie['league'];
				return $this->showDate($league,$matchdate);
			}
		}
		
		return $this->showLatest(1);
	}

	public function showLatest($league)
	{
		$leagueseason = LeagueSeason::find($league);
		return $this->showDate($league,$leagueseason->end_date);
	}
	
	public function showDate($league, $matchdate)
	{
		$cookie = Cookie::get('soccer-tables');
		if($cookie) $cookie_array = json_decode($cookie,true);
		else $cookie_array = array();
		$cookie_array['date'] = $matchdate;
		$cookie_array['league'] = $league;
		$cookie = Cookie::forever('soccer-tables',json_encode($cookie_array));
		
		$leagueseason = LeagueSeason::find($league);
		if(isset($leagueseason))
		{
			$matches = Matches::onDate($league,$matchdate);
            $directives = DirectiveEvents::onDate($league,$matchdate);
			$leagues = LeagueSeason::all();

			$dates = array(
				'matchdate' => $matchdate,
				'prev' => $this->previousDate($league,$matchdate),
				'next' => $this->nextDate($league,$matchdate));
				
			$leaguetable = $this->calcLeagueTable($league,$matchdate);
            		
			$view = view('soccertables/matches')->with(
				array(
					'dates' => $dates, 
					'matches' => $matches,
                    'directives' => $directives,
					'leagues' => $leagues,
					'leagueseason' => $leagueseason,
                    'leaguetable' => $leaguetable,
					'cookie' => $cookie_array,
                    'apache_version' => $this->getApacheVersion(),
                    'mysql_version' => DBQuery::getMySQLVersion()
			));
			return Response::make($view)->withCookie($cookie);
		}
		else
			return view('soccertables/error');
	}

    private function getApacheVersion()
    {
        $words = explode('/', apache_get_version(), 2);
        if(isset($words))
            $version = explode(' ', $words[1], 2);
            if(isset($version)) return $version[0];
        return "---";
        
    }

    private function previousDate($league,$date)
    {
        $prevMatchDate = Matches::previousDate($league,$date);
        $prevDirectiveDate = DirectiveEvents::previousDate($league,$date);
        if(($prevDirectiveDate != 'null') && ($prevDirectiveDate > $prevMatchDate))
            return $prevDirectiveDate;
        return $prevMatchDate;
    }
    
    private function nextDate($league,$date)
    {
        $nextMatchDate = Matches::nextDate($league,$date);
        $nextDirectiveDate = DirectiveEvents::nextDate($league,$date);
        if(($nextDirectiveDate != 'null') && ($nextDirectiveDate < $nextMatchDate))
            return $nextDirectiveDate;
        return $nextMatchDate;
    }
	
    public function showLeagueTable($league, $matchdate)
	{
		if(!Request::ajax()) return view('error');
		
		$leaguetable = $this->calcLeagueTable($league,$matchdate);

		return view('soccertables/league')->with(
			array(
				'leaguetable' => $leaguetable
			)
        );
	}

	public function showFormTable($league, $matchdate)
	{
		if(!Request::ajax()) return view('error');
		
		$tablematches = Matches::upToDate($league,$matchdate);
		$leaguetable = $this->calcFormTable($league,$tablematches);
		
		return view('soccertables/league')->with(
			array(
				'leaguetable' => $leaguetable
			));
	}

	private function calcLeagueTable($league,$matchdate)
	{
        $matches = Matches::upToDate($league,$matchdate);
        $directives = DirectiveEvents::upToDate($league,$matchdate);
        $leagueseason = LeagueSeason::find($league);
        
        $table_sort_fk = $leagueseason->table_sort_fk;
        if($leagueseason->num_phases > 1)
        {
            if($matchdate<$leagueseason->start_date) 
                $matchdate=$leagueseason->start_date;
            else if($matchdate>$leagueseason->end_date)
                $matchdate=$leagueseason->end_date;

            $phases = LeaguePhases::onDate($league,$matchdate);
            if(isset($phases))
            {
                $table_sort_fk = $phases->table_sort_fk;
                $team_sections = LeagueSections::onPhase($phases->id);
            }
        }
                
		$league_table = $this->createLeagueTable($league);

		foreach($matches as $match)
        {
            $this->addToLeagueTable($league_table[$match->home_team_fk],
                $match->home_score,$match->away_score);
            $this->addToLeagueTable($league_table[$match->away_team_fk],
                $match->away_score,$match->home_score);
		}
        foreach($directives as $directive)
        {
            $this->deductPoints($league_table[$directive->team_fk],
                $directive->points_deduction);
        }

        switch($table_sort_fk)
        {
        case 2: // split at end of season
                if(isset($team_sections))
                    $this->setSections($league_table, $team_sections);
                    usort($league_table,array($this,'compare2'));
                    $this->setSplit($league_table, 2);
                    break;
        default: // regular league
                usort($league_table,array($this,'compare'));
        }
		$this->setColours($league, $league_table);
		return $league_table;
	}

	private function calcFormTable($league,$matches)
	{
		$league_table = $this->createLeagueTable($league);
		for($i=count($matches)-1;$i>=0;$i--)
		{
			$match = $matches[$i];

            $ht = &$league_table[$match->home_team_fk];
            if($ht['played']<6)
                $this->addToLeagueTable($ht,
                    $match->home_score,$match->away_score);
            $at = &$league_table[$match->away_team_fk];
            if($at['played']<6)
                $this->addToLeagueTable($at,
                    $match->away_score,$match->home_score);
		}
		
		usort($league_table,array($this,'compare'));
		return $league_table;
	}
	
	private function compare($team1,$team2)
	{
		$pts1 = $team1['points'];
		$pts2 = $team2['points'];
		if($pts1>$pts2) return -1;
		else if($pts1<$pts2) return 1;
		$gd1 = $team1['diff'];
		$gd2 = $team2['diff'];
		if($gd1>$gd2) return -1;
		else if($gd1<$gd2) return 1;
		if($team1['for']>$team2['for']) return -1;
		else if($team1['for']<$team2['for']) return 1;
		if($team1['teamname']>$team2['teamname']) return 1;
		return -1;
	}

    private function compare2($team1,$team2)
	{
        $section1 = $team1['section'];
        $section2 = $team2['section'];
		if($section1<$section2) return -1;
		else if($section1>$section2) return 1;
        return $this->compare($team1,$team2);
    }

	private function addToLeagueTable(&$row,$for,$against)
	{
		$row['played']++;
		$row['for'] += $for;
		$row['against'] += $against;
		$row['diff'] = $row['for'] - $row['against'];
		
		if( $for > $against) {$row['won']++;$row['points']+=3;}
		else if( $for == $against) {$row['drawn']++;$row['points']+=1;}
		else $row['lost']++;
	}
	
	private function deductPoints(&$row,$pts_deduction)
	{
        $row['pts_deducted'] += $pts_deduction;
		$row['points'] += $pts_deduction;        
    }
    
	private function createLeagueTable($leagueseason)
	{
		$leaguetable = array();
		$teams = LeagueTeams::teams($leagueseason);
		foreach($teams as $team)
		{
			$name = $team->team->team_name;
			$leaguetable[$team->team_fk] = $this->createLeagueTableRow($name);
		}
		return $leaguetable;
	}
	
	private function createLeagueTableRow($name)
	{
		return array(
			'played' => 0, 'teamname' => $name,
			'won' => 0,'drawn' => 0,'lost' => 0,
			'for' => 0,'against' => 0,'diff' => 0,
			'points' => 0, 'pts_deducted' => 0, 'section' => 0,
			'colour' => '', 'border' => 0);
	}

    private function setSections(&$leaguetable, $teamsections)
    {
        foreach($teamsections as $teamsection)
        {
            $team = $teamsection->team;
            $leaguetable[$teamsection->team_fk]['section'] = $teamsection->league_section;
        }
    }

    private function setSplit(&$leaguetable, $tablesort_fk)
    {
        $pos = TableSort::find($tablesort_fk)->pos;
        $leaguetable[5]['border'] = 2;
    }

	private function setColours($leagueseason,&$leaguetable)
	{
        $leaguecolours = LeagueColours::getColours($leagueseason);
        $numrows = count($leaguecolours);
        $row = 0;
        $numteams = count($leaguetable);
             
        for($pos=1;$pos<=$numteams;$pos++)
        {
            if($pos == $leaguecolours[$row]->pos)
            {
                $colour = $leaguecolours[$row]->colour;
                if($row < $numrows - 1) $row++;
                $leaguetable[$pos-1]['border'] += 1;
            }
            $leaguetable[$pos-1]['colour'] = $colour;
        }
    }
}

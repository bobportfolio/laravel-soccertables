<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

// class

class DBQuery
{
    static public function getMySQLVersion()
    {
        $words = 
            explode('-', DB::select('select version()')[0]->{'version()'}, 2);
        return isset($words)?$words[0]:"---";
    }
}

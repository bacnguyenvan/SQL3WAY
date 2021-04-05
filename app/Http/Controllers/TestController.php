<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Architect;
use App\Building;
use App\Worker;

class TestController extends Controller
{
    public function test()
    {
    	// 1. show all content architect
	    	// c1.
	    	$architect = Architect::all();
	    	// c2.
	    	$architect = DB::table('architect')->get();
	    	// c3.
	    	$architect = DB::select(" 
	    		SELECT * FROM architect
	    	");
	    	// dd($architect);

	    // 2. show list include name, sex of architect
	    	// c1. 
	    	$architect = Architect::select('name','sex')->get();
	    	// c2.
	    	$architect = DB::table('architect')->select('name','sex')->get();
	    	// c3.
	    	$architect = DB::select(" 
	    		SELECT name, sex FROM architect
	    	");
	    	// dd($architect);

	    // 3. show birthday may be exist of architect ( not duplicate )
	    	// c1.
	    	$architect = Architect::select('birthday')->distinct()->get();
	    	// c2.
	    	$architect = DB::table('architect')->select('birthday')->distinct()->get();
	    	// c3.
	    	$architect = DB::select("
	    		SELECT DISTINCT birthday FROM architect 
	    	");
	    	// dd($architect);

	    // 4. Show list architect( name, birthday ) by birthday increment
	    	// c1.
	    	$architect = Architect::select('name','birthday')->orderBy('birthday','asc')->get();
	    	// c2.
	    	$architect = DB::table('architect')->select('name','birthday')->orderBy('birthday','asc')->get();
	    	// c3.
	    	$architect = DB::select("
	    		SELECT name, birthday FROM architect ORDER BY birthday ASC
	    	");
	    	// dd($architect);

	    // 5. show list build which has cost increment. If equal then sort name alpha
	    	// c1.
	    	$builds = Building::orderBy('cost','asc')->orderBy('name','asc')->get();
	    	// c2.
	    	$builds = DB::table('building')->orderBy('cost','asc')->orderBy('name','asc')->get();
	    	// c3.
	    	$builds = DB::select("
	    		SELECT * FROM building ORDER BY cost ASC, name ASC
	    	");
	    	// dd($builds);

	    // 6. Show info of architect "nguyen anh thu"
	    	// c1.
	    	$architect = Architect::where('name','nguyen anh thu')->get();
	    	// c2.
	    	$architect = DB::table('architect')->where('name','nguyen anh thu')->get();
	    	// c3.
	    	$architect = DB::select("
	    		SELECT * FROM architect WHERE name = 'nguyen anh thu'
	    	");
	    	
	    	
	    // 7. Show name, birthday of works who has skill : han or dien
	    	// c1.
	    	$workers = Worker::select('name','birthday','skill')
	    					-> where('skill','han')
	    					-> orWhere('skill','dien')
	    					-> get();
	    	// c2. 
	    	$workers = DB::table('worker')->select('name','birthday','skill')
	    					-> where('skill','han')
	    					-> orWhere('skill','dien')
	    					-> get();
	    	// c3.
	    	$workers = DB::select("
	    		SELECT name, birthday, skill FROM worker WHERE skill = 'han' OR skill = 'dien'
	    	");
	    	dd($workers);

	    // 8. 
    }
}

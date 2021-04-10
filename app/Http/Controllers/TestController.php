<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Architect;
use App\Building;
use App\Worker;
use App\Contractor;
use App\Work;
use App\Design;

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

	    // III. WHERE
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
	    	

	    // 8. show name who has skill : han or dien and birthday > 1948
	    	// c1.
	    	$workers = Worker::select('name','birthday')
	    					-> where(function($q){
	    						$q -> where('skill','han')
	    						   -> orWhere('skill','dien');
	    					})
	    					-> where('birthday','>',1948)
	    					-> get();
	    	// c2.
	    	$workers = DB::table('worker')->select('name','birthday','skill')
	    						-> where(function($q){
	    						$q -> where('skill','han')
	    						   -> orWhere('skill','dien');
	    					})
	    					-> where('birthday','>',1948)
	    					-> get();
	    	// c3.
	    	$workers = DB::select("
	    		SELECT name,birthday FROM worker WHERE skill = 'han' or skill = 'dien' AND birthday > 1948
	    	");
	    	// dd($workers);

	    // 9. show works has start year < 20 old
	    	// c1. 
	    	$workers = DB::select("
	    		SELECT * FROM worker WHERE year - birthday < 20
	    	");

	    	// c2.
	    	$workers = DB::table('worker')->whereRaw("year-birthday < 20")->get();

	    	

	    // 10.  show works has birthday 1940, 1945 , 1948
	    	//c1.
	    	$workers = Worker::whereIn('birthday',[1940,1945,1948])->get();

	    	// c2.
	    	$workers = DB::select("
	    		SELECT * FROM worker WHERE birthday IN (1940,1945,1948)
	    	");
	    	// dd($workers);

	    // 11. show builds has cost 200->500
	    	// c1.
	    	$buildings = Building::whereBetween('cost',[200,500])->get();

	    	// c2.
	    	$buildings = DB::select("
	    		SELECT * FROM building WHERE cost BETWEEN 200 AND 500
	    	");
	    	// dd($buildings);

	    // 12. Show contractors has not phone
	    	// c1.
	    	$contractors = Contractor::whereRaw("phone is Null")->get();

	    	// c2.
	    	$contractors = DB::select("
	    		SELECT * FROM contractor WHERE phone IS NULL 
	    	");
	    	// dd($contractors);

	    // IV. Caculator
	    	// 1. Statistical total architect

	    		// c1. 
	    		$total = Architect::count();

	    		// c2.
	    		$total = DB::table('architect')
	    					-> selectRaw("COUNT(*) as totalA")
	    					-> get();
	    		// c3.
	    		$total = DB::table('architect')
	    					-> select(DB::raw('count(*) as totala'))
	    					-> get();
	    		

	    	// 2. Statistical total architect male
	    		// c1.
	    		$total = Architect::selectRaw("COUNT(*) as totalA")
	    							-> where('sex',1)
	    							-> get();

	    		// c2.
	    		$total = Architect::where('sex',1)->count();

	    		// c3.
	    		$total = DB::table("architect")
	    					-> select(DB::raw("COUNT(*) AS totala"))
	    					-> get();
	    		// dd($total);

	    	// 3. What day work join building the most
	    			// c1.
			    	$dayMax = Work::max('total');
			    	// c2.
			    	$dayMax = DB::table("work")
			    					-> selectRaw("Max(total) as maxTotal")
			    					-> get();
			    	// dd($dayMax);

			// 6.  what total cost for designing building of works
			    	// c1.
			    	$total = DB::table('design')
			    					-> selectRaw("SUM(benefit) as sum")
			    					-> get();

			    	$total = DB::select("
			    		SELECT SUM('benefit') as Sbe FROM work
			    	");
			    	// dd($total);

			// 7.  what cost to pay for designing building of architect has building_id = 1
			    	// c1.
			    	$cost = DB::table('design')->selectRaw("SUM(benefit) as sum, building_id")
			    						->where('building_id',1)
			    						->groupBy('building_id')
			    						->get();
			    	// dd($cost);

			// 8. caculate avg total work building of worker
			// Tim trung binh so ngay tham gia cong trinh cua cong nhan
				// c1.
				$avg =  DB::table('work')->AVG('total');
				// c2.
				$avg = DB::table('work')->selectRaw("AVG(total) as avgDate")->get();
				// c3.
				$avg = DB::select("SELECT AVG(total) as avgTotal FROM work");
				// dd($avg);

			// 9. Caculate benefit of architect ( benefit * 100)
				// c1,
				$benefit = DB::table('design')
								-> selectRaw('architect_id, benefit*100 as be')
								-> get();

			// 10. Show info of architect : name , age : 20 , 22 = now - birthday
				$architects = DB::table('architect')
								-> selectRaw("name, (2021 - birthday) as age")
								-> get();
				// dd($architects);

		// V. SELECT CHILD
			// 1. Show info building which has cost tallest
				// c1.
				$building = DB::select(" 
					SELECT * FROM building WHERE cost = 
					(
						SELECT MAX(cost) FROM building
					)
					
				");

				// c2.
				$building = Building::orderBy('cost','desc')->first();

				// c3.

				$building = DB::table('building')
								-> where('cost',function($q){
									 $q -> selectRaw("MAX(cost) FROM building");
								})-> get();
			

			// 2. Show info building which has cost larger all building o Can Tho

				// c1.
				$buildings = DB::select("
					SELECT * FROM building WHERE cost > 
						( SELECT MIN(cost) FROM building WHERE city = 'can tho')
					AND city != 'can tho'
				");

				// c2.
				$buildings = DB::table('building')
								-> where('cost','>', function($q){
									$q -> selectRaw("MAX(cost) FROM building WHERE city = 'can tho'");
								})
								-> where('city','<>','can tho')
								-> get();
				
			// 3. show info building has not architect design
								DB::enableQueryLog();
				// c1.
				$buildings = DB::table('design')
								-> whereNotIn('architect_id', function($q){
									$q -> select("id")->from("architect");
								})
								-> get();
				
				

				// dd($buildings);

		// VI. 
				// 1. show benefit average of each architect

				$architect = DB::table('design')
								-> selectRaw("architect_id, AVG(benefit) as avgBenefit")
								-> groupBy('architect_id')
								-> get();
				// dd($architect);
				// 2. show cost invest of building of each cities
				$costs = DB::table('building')
							-> selectRaw("city, SUM(cost) as total")
							-> groupBy('city')
							-> get();

				// 3. what building has cost pay architect larger 20

				$buildings = DB::table('design')
								-> selectRaw('building_id, SUM(benefit) as total')
								-> groupBy('building_id')
								-> having('total','>',20)
								-> get();

				// 4. what cities  has at least 2 architect graduating

				$cities = DB::table('architect')
								-> selectRaw("place, COUNT(*)as total")
								-> groupBy('place')
								-> having('total','>',1)
								-> get();



		// VII.
			 	




    }
}

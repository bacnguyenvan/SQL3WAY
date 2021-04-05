<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ArchitectService;

use App\Building;
use App\Architect;
use App\Worker;
use App\Work;
use App\Contractor;
use App\Design;
use DB;


class MainController extends Controller
{
    public function list(Request $request)
    {
        

        // 1. Hiển thị thông tin công trình có chi phí cao nhất
        $buildingLatest = Building::orderBy('cost','desc')->first();

        // 2. Show info buildings which has cost greater trung bình cost
        $buildings = Building::where('cost','>',function($q){
            $q -> selectRaw("avg(cost) from building");
        })
        ->get();
        DB::enableQueryLog();
        // 3. Hiển thị thông tin công trình có chi phí lớn hơn tất cả các công trình xây dựng ở Cần Thơ
        $buildings = Building::where('cost','>',function($q){
            $q -> selectRaw("Max(cost) from building where city = 'can tho'");
        })-> get();

        $list = DB::select("
            SELECT * FROM building where cost > ALL 
            (
                SELECT cost from building where city = 'can tho'
            )
        ");

        // 4. Hiển thị thông tin công trình có chi phí lớn hơn 1 trong các công trình dc xây dựng ở Cần Thơ
        $buildings = Building::where('cost','>',function($q){
            $q -> selectRaw("MIN(cost) FROM building where city='can tho' ");
        })->where('city','<>','can tho')->get();

        $buildings = DB::select("
            SELECT * FROM building where cost > ANY 
            (
                SELECT cost from building where city = 'can tho' 
            ) and city <> 'can tho'
        ");

        // 5. Hiển thị thông tin công trình chưa có kts thiết kế
        $buildings = DB::select("
            SELECT * FROM building where id NOT IN 
            (
                SELECT building_id from design
            )
        ");


        $buildings = Building::whereNotIn('id',function($q){
            $q -> selectRaw("building_id from design");
        })->get();

        // 6. Hiển thị thù lao trung bình của từng kts
        $architects = Design::selectRaw("architect_id, architect.name, AVG(benefit) as benefit")
                            -> leftjoin('architect','architect.id','design.architect_id')
                            -> groupBy('architect_id')
                            -> get();

        // 7. Hiển thị tong chi phí đầu tư cho các công trình ở mỗi thành phố
        $buildings = Building::selectRaw("city, SUM(cost) as cost")
                            -> groupBy('city')
                            -> get();

        // 8. Tìm các công trình có chi phí trả cho kts > 20
        $buildings = Design::selectRaw("building_id, SUM(benefit) as Sbenefit")
                            -> groupBy('building_id')
                            -> having('Sbenefit','>',20)
                            -> get();

        // dd(DB::getQueryLog());

        dd($buildings);

    	return view('front.index',['list'=> $list]);
    }

    public function building()
    {
        $list = Building::all();
        // in ra cong trinh voi tong so luong kts thiet ke cong trinh do, va cong trinh co dat chuan 5sao (chi phi dau tu >= 30)?
        
        $qCountArchitect = DB::raw("(
            SELECT count(*) FROM design 
            Where design.building_id = building.id 
        ) as architects");

        $qFiveStar = DB::raw("(
            CASE 
                WHEN (
                    SELECT SUM(benefit) FROM design
                    Where design.building_id = building.id
                ) >= 30 THEN true
            ELSE 
                false 
            END
        ) as isBuildingActive");

        
        $result = Building::select('id','name',$qCountArchitect,$qFiveStar)->get();
        
        return view('front.building',['list'=> $result]);

    }
}

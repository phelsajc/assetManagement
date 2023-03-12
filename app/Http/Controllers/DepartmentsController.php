<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Department;
use App\Events\DepartmentEvent;
use DB;

class DepartmentsController extends Controller
{  
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $length = 10;
        $start = $request->start?$request->start:0;
        $val = $request->searchTerm2;
        if($val!=''||$start>0){   
            $data =  DB::connection('pgsql')->select("select * from departments where company department '%".$val."%' LIMIT $length offset $start");
            $count =  DB::connection('pgsql')->select("select * from departments where department ilike '%".$val."%' ");
        }else{
            $data =  DB::connection('pgsql')->select("select * from departments LIMIT $length");
            $count =  DB::connection('pgsql')->select("select * from departments");
        }
        
        $count_all_record =  DB::connection('pgsql')->select("select count(*) as count from departments");

        $data_array = array();

        foreach ($data as $key => $value) {
            $arr = array();
            $arr['dept'] =  $value->department;
            $arr['loc'] =  $value->location;
            $arr['id'] =  $value->id;
            $arr['bizboxid'] =  $value->bizboxid;
            $data_array[] = $arr;
        }
        $page = sizeof($count)/$length;
        $getDecimal =  explode(".",$page);
        $page_count = round(sizeof($count)/$length);
        if(sizeof($getDecimal)==2){            
            if($getDecimal[1]<5){
                $page_count = $getDecimal[0] + 1;
            }
        }
        $datasets = array(["data"=>$data_array,"count"=>$page_count,"showing"=>"Showing ".(($start+10)-9)." to ".($start+10>$count_all_record[0]->count?$count_all_record[0]->count:$start+10)." of ".$count_all_record[0]->count, "patient"=>$data_array]);
        return response()->json($datasets);
    } 

    public function find_dept(Request $request)
    {
        $query_data="SELECT PK_mscWarehouse AS BizboxID, description AS DepartmentName 
        FROM mscWarehouse WHERE isAssets = 1         
        AND description NOT LIKE 'CIP%'  and
        description like '%$request->val%'";

        $bizboxPatients = DB::connection('bizbox')->select( $query_data );
        $data_array = array();
        foreach ($bizboxPatients as $key => $value) {
            $arr = array();
            $arr['bizboxid'] =  $value->BizboxID;
            $arr['dept'] =  $value->DepartmentName;
            $data_array[] = $arr;
        }
        $datasets = array(["data"=>$data_array]);
        return response()->json($data_array);
    }   

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $p = new Department;
        $p->department = $request->dept;
        $p->location = $request->loc;
        $p->status = $request->status; 
        $p->bizboxid = $request->bizboxid; 
        $p->save(); 
        broadcast(new DepartmentEvent($request->dept,$request->bizboxid));//->toOthers();
        return true;
    }

    public function edit($id)
    {
        $data = Department::where(['id'=>$id])->first();
        return response()->json($data);
    }
    
    public function update(Request $request)
    {
        Department::where(['id'=>$request->id])->update([
            'department'=> $request->data['dept'],
            'location'=> $request->data['loc'],
            'status'=> $request->data['status'],
            'bizboxid'=> $request->data['bizboxid'],
        ]);
        return true;
    }

    public function Delete($id)
    {
        Company::where('id',$id)->delete();
        return true;
    }

    public function getCompanies()
    {
        $p = Company::all();
        return response()->json($p);
    }
   
}

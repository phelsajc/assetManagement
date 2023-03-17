<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Vendor;
use App\Events\VendorEvent;
use DB;

class VendorController extends Controller
{  
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $length = 10;
        $start = $request->start?$request->start:0;
        $val = $request->searchTerm2;
        if($val!=''||$start>0){   
            $data =  DB::connection('pgsql')->select("select * from vendors where name name '%".$val."%' LIMIT $length offset $start");
            $count =  DB::connection('pgsql')->select("select * from vendors where name ilike '%".$val."%' ");
        }else{
            $data =  DB::connection('pgsql')->select("select * from vendors LIMIT $length");
            $count =  DB::connection('pgsql')->select("select * from vendors");
        }
        
        $count_all_record =  DB::connection('pgsql')->select("select count(*) as count from vendors");

        $data_array = array();

        foreach ($data as $key => $value) {
            $arr = array();
            $arr['id'] =  $value->id;
            $arr['bizboxid'] =  $value->bizboxid;
            $arr['VendorName'] =  $value->name;
            $arr['address'] =  $value->address;
            $arr['contact'] =  $value->contactno;
            $arr['email'] =  $value->email;
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

    public function find_vend(Request $request)
    {
        $query_data="SELECT top 10 PK_psDatacenter AS BizboxID, a.fullname AS VendorName,  ISNULL(a.praddress,'') AS Address, CASE WHEN a.prtelno IS NOT NULL THEN a.prtelno ELSE 
       ISNULL(a.mobilephone,'') END AS ContactNumber, ISNULL(a.email,'') AS email    FROM         dbo.psDatacenter AS a INNER JOIN   dbo.faVendors AS b  
       ON b.PK_faVendors = a.PK_psDatacenter WHERE a.fullname != '' and
       a.fullname like '%$request->val%'";

        $bizboxPatients = DB::connection('bizbox')->select( $query_data );
        $data_array = array();
        foreach ($bizboxPatients as $key => $value) {
            $arr = array();
            $arr['bizboxid'] =  $value->BizboxID;
            $arr['VendorName'] =  $value->VendorName;
            $arr['add'] =  $value->Address;
            $arr['contact'] =  $value->ContactNumber;
            $arr['email'] =  $value->email;
            $data_array[] = $arr;
        }
        $datasets = array(["data"=>$data_array]);
        return response()->json($data_array);
    }   

    public function store(Request $request)
    {
        $check = Vendor::where(['bizboxid'=>$request->bizboxid])->first();
        date_default_timezone_set('Asia/Manila');
        if($check==null){
            $p = new Vendor;
            $p->name = $request->vendorName;
            $p->contactno = $request->contact; 
            $p->address = $request->address; 
            $p->email = $request->email;
            $p->status = $request->status; 
            $p->bizboxid = $request->bizboxid;  
            $p->created_by = $request->userid;
            $p->created_dt = date("Y-m-d H:i"); 
            $p->save(); 
            broadcast(new VendorEvent($request->dept,$request->bizboxid));//->toOthers();
            return true;
        }else{
            return response()->json('Duplicate Department');
        }
    }

    public function edit($id)
    {
        $data = Vendor::where(['id'=>$id])->first();
        return response()->json($data);
    }
    
    public function update(Request $request)
    {
        Vendor::where(['id'=>$request->id])->update([
            'name'=> $request->data['vendor'],
            'contactno'=> $request->data['contactno'],
            'address'=> $request->data['address'],
            'email'=> $request->data['email'],
            'status'=> $request->data['status'],
            'updated_by'=> auth()->id(),
            'updated_dt'=>   date("Y-m-d H:i"),
        ]);
        return true;
    }

    public function Delete($id)
    {
        Vendor::where('id',$id)->delete();
        return true;
    }

    public function getCompanies()
    {
        $p = Vendor::all();
        return response()->json($p);
    }
   
}

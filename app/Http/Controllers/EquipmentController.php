<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Products;
use App\Model\ReceivedProducts;
use App\Events\RegisterEvent;
use DB;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $length = 10;
        $start = $request->start?$request->start:0;
        $val = $request->searchTerm2;
        if($val!=''||$start>0){   
            $data =  DB::connection('pgsql')->select("select * from equipments where description ilike '%".$val."%' or bizboxid ilike '%".$val."%' LIMIT $length offset $start");
            $count =  DB::connection('pgsql')->select("select * from equipments where description ilike '%".$val."%' or bizboxid ilike '%".$val."%'");
        }else{
            $data =  DB::connection('pgsql')->select("select * from equipments LIMIT $length");
            $count =  DB::connection('pgsql')->select("select * from equipments");
        }
        
        $count_all_record =  DB::connection('pgsql')->select("select count(*) as count from equipments");

        $data_array = array();

        foreach ($data as $key => $value) {
            $arr = array();
            $arr['id'] =  $value->id;
            $arr['desc'] =  $value->description;
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

    public function find_item(Request $request)
    {
        $query_data="SELECT	top 10 PK_iwItems AS BizboxID, itemdesc AS ItemDescription  
        FROM        dbo.iwItems AS a         
        WHERE       itemgroup = 'EQP'         
        AND isactive = 1 and
        itemdesc like '%$request->val%'";
        $bizboxPatients = DB::connection('bizbox')->select( $query_data );
        $data_array = array();
        foreach ($bizboxPatients as $key => $value) {
            $arr = array();
            $arr['bizboxid'] =  $value->BizboxID;
            $arr['desc'] =  $value->ItemDescription;
            $data_array[] = $arr;
        }
        $datasets = array(["data"=>$data_array]);
        return response()->json($data_array);
    }   

    public function store(Request $request)
    {        
        $check = Products::where(['bizboxid'=>$request->bizboxid])->first();
        date_default_timezone_set('Asia/Manila');
        if($check==null){
            $p = new Products;
            $p->description = $request->desc;
            $p->life = $request->life;
            $p->bizboxid = $request->bizboxid;
            $p->status = $request->status?1:0;
            $p->isforpreventive = $request->ispreventive;  
            $p->created_by = $request->userid;
            $p->created_dt = date("Y-m-d H:i"); 
            $p->save();
            broadcast(new RegisterEvent($request->desc,$request->bizboxid));//->toOthers();
            return true;
        }else{
            return response()->json('Duplicate Equipment');
        }
    }

    public function edit($id)
    {
        $data = Products::where(['id'=>$id])->first();
        return response()->json($data);
    }
    
    public function update(Request $request)
    {
        Products::where(['id'=>$request->id])->update([
            'isforpreventive'=> $request->data['isPreventive'],
            'status'=> $request->data['active'],
            'description'=> $request->data['desc'],
            'life'=>  $request->data['life'],
            'updated_by'=> auth()->id(),
            'updated_dt'=>   date("Y-m-d H:i"),
        ]);
        return response()->json(true);
    }

    public function Delete($id)
    {
        ReceivedProducts::where('id',$id)->delete();
        return true;
    }

    public function searchProduct(Request $request){
        $query = DB::connection('pgsql')->select("select * from received_products where product ILIKE '%$request->val%' or description ILIKE '%$request->val%'");
        $data = array();
        foreach ($query as $key => $value ) {
            $arr = array();
            $arr['id'] = $value->id;
            $arr['product'] = $value->product;
            $arr['description'] = $value->description;
            $arr['price'] =  $value->price;
            $arr['code'] = $value->code;
            $arr['qty'] = $value->quantity;
            $data[] = $arr;
        }
        return response()->json($data);
    }
}

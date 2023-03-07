<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Products;
use App\Model\ReceivedProducts;
use DB;

class EquipmentController extends Controller
{
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
        date_default_timezone_set('Asia/Manila');
        $product = Products::where(['id'=>$request->pid])->first();
        $p = new ReceivedProducts;
        $p->product = $product->product;
        $p->quantity = $request->qty;
        $p->date_receive = $request->dop;
        $p->pid = $request->pid;
        $p->created_dt = date("Y-m-d H:i");
        $p->created_by = $request->userid; 
        $p->save();
        return true;
    }

    public function edit($id)
    {
        $data = ReceivedProducts::where(['id'=>$id])->first();
        return response()->json($data);
    }
    
    public function update(Request $request)
    {
        $product = Products::where(['id'=>$request->data['pid']])->first();
        ReceivedProducts::where(['id'=>$request->id])->update([
            'product'=> $product->product,
            'pid'=> $request->data['pid'],
            'quantity'=> $request->data['qty'],
            'date_receive'=> $request->data['dor'],
            'updated_by'=> $request->data['userid'],
            'updated_dt'=>   date("Y-m-d H:i"),
        ]);
        return response()->json(true);
        return true;
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

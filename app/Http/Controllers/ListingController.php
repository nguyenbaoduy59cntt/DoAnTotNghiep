<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ListingController extends Controller
{
    public function index(Request $request, $modelName)
    {
        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();
        
        //Lấy dữ liệu từ db
         $model = '\App\Models\\'.ucfirst($modelName); //ucfirst: auto làm chữ cái đầu in hoa
         $model = new $model;
         $configs = $model->listingConfigs(); //gọi hàm đã tạo bên model
        // var_dump($configs);exit;
        
         //trường lấy id để sửa
         $modelID = strtolower($modelName).'ID';
       
         $editingConfigs = $model->editingConfigs();
        // var_dump($editingConfigs);exit;

        $filterResult = $model->getFilter($request, $configs, $modelName);
         
        //Sắp xếp sản phẩm
         $orderBy = [
            'field' => 'created_at',
            'sort'=> 'asc'
         ];

         if($request->input('sort'))
         {
             $field = substr($request->input('sort'),0,strrpos($request->input('sort'), "_"));
             $sort = substr($request->input('sort'),strrpos($request->input('sort'), "_") + 1);
             $orderBy = [
                'field' => $field,
                'sort'=>$sort
             ];
         }
        // var_dump($filterResult['conditions']);exit;
         
        $records = $model->getRecords($filterResult['conditions'], $orderBy);

        //INSERT DATA
        if($request ->method() == "POST" && isset($_POST['submit_add']))
        {
            $model ->addData($request, $modelName,$editingConfigs);
        }
       
        return view('admin.listing',[
            'user'=> $admin,
            'employee' => $employee,
            'records' => $records,
            'configs' => $filterResult['configs'],
            'modelName' => $modelName,
            'title' => $model->title,
            'orderBy'=>$orderBy,
            'modelID' => $modelID
            ]);
    }


    //Hiển thị danh sách sản phẩm theo nhà cung cấp
    public function listingProduct(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();

        $model = '\App\Models\Product';
        $model = new $model;
        $configs = $model->listingConfigs(); 


        $supplierName = DB::table('suppliers')->where('supplierID', $id)->value('supplierName');

        // $data = DB::table('products')->where('supplierID', $id)->get();
        
        $modelID = 'productID';
       
        //var_dump($modelID);exit;

         $editingConfigs = $model->editingConfigs();
        //var_dump($editingConfigs);exit;

        $filterResult = $model->getFilter($request, $configs, 'Product');

         
        //Sắp xếp sản phẩm
         $orderBy = [
            'field' => 'productID',
            'sort'=> 'asc'
         ];

         if($request->input('sort'))
         {
             $field = substr($request->input('sort'),0,strrpos($request->input('sort'), "_"));
             $sort = substr($request->input('sort'),strrpos($request->input('sort'), "_") + 1);
             $orderBy = [
                'field' => $field,
                'sort'=>$sort
             ];
         }
         
        $filterResult['conditions'][] = [
            'field' => 'supplierID',
            'where' => '=',
            'value' => $id
        ];

         $records = $model->getRecords($filterResult['conditions'], $orderBy);


        //INSERT DATA
        if($request ->method() == "POST" && isset($_POST['submit_add'])) //or là:  if($request ->method() == "POST" && isset(($request->all())['submit']))
        {
            $model ->addData($request, 'productID',$editingConfigs);
        }
       
        return view('admin.listing',[
            'user'=> $admin,
            'employee'=> $employee,
            'supplierName' => $supplierName,
            'records' => $records,
            'configs' => $filterResult['configs'],
            'modelName' => 'Product',
            'title' => $model->title,
            'orderBy'=>$orderBy,
            'modelID' => $modelID,
            'isSup' => true,
            'id' =>$id
            ]);
    }

    //danh sách chi tiết sản phẩm
    public function listingDetailProduct(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();

        $modelName = 'ProductDetail';
        
        //Lấy dữ liệu từ db
         $model = '\App\Models\\'.ucfirst($modelName); //ucfirst: auto làm chữ cái đầu in hoa
         $model = new $model;
         $configs = $model->listingConfigs(); //gọi hàm đã tạo bên model

         //trường lấy id để sửa
         $modelID = 'productDetailID';
       
        //var_dump($modelID);exit;

         $editingConfigs = $model->editingConfigs();
        //var_dump($editingConfigs);exit;

        $filterResult = $model->getFilter($request, $configs, $modelName);
        $filterResult['conditions'][] = [
            'field' => 'productID',
            'where' => '=',
            'value' => $id
        ];
        //Sắp xếp sản phẩm
         $orderBy = [
            'field' => strtolower($modelName).'ID',
            'sort'=> 'asc'
         ];


         if($request->input('sort'))
         {
             $field = substr($request->input('sort'),0,strrpos($request->input('sort'), "_"));
             $sort = substr($request->input('sort'),strrpos($request->input('sort'), "_") + 1);
             $orderBy = [
                'field' => $field,
                'sort'=>$sort
             ];
         }
         
         $records = $model->getRecords($filterResult['conditions'], $orderBy);

        //INSERT DATA
        if($request ->method() == "POST" && isset($_POST['submit_add'])) //or là:  if($request ->method() == "POST" && isset(($request->all())['submit']))
        {
            $model ->addData($request, $modelName,$editingConfigs);
        }
       
        return view('admin.listing-detail-product',[
            'user'=> $admin,
            'employee' => $employee,
            'records' => $records,
            'configs' => $filterResult['configs'],
            'modelName' => $modelName,
            'title' => $model->title,
            'orderBy'=>$orderBy,
            'modelID' => $modelID
            ]);
    }
}

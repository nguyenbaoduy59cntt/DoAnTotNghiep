<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    public function create(Request $request, $modelName)
    {
        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();
       
        $model = '\App\Models\\'.ucfirst($modelName);
        $model = new $model;

        $configs = $model->editingConfigs();
        $filterResult = $model->getFilter($request, $configs, $modelName);

        $orderBy = [
            'field' => 'created_at',
            'sort'=> 'desc'
        ];

        $records = $model->getRecords([], $orderBy)[0];
        
        $ID = $records[$configs[0]['field']];
       
        if($modelName == 'ImportOrder')
        {
            $sau = substr($ID,strrpos($ID, "_25")+4) + 1;
            $truoc = substr($ID,0, strrpos($ID, "_25")+4); 
            $ID =  $truoc. $sau ;
        }

        //lay ID
        $model2 =  '\App\Models\ProductDetail';
        $model2 = new $model2;

        $configs2 = $model2->editingConfigs();
        
        $orderBy = [
            'field' => 'created_at',
            'sort'=> 'desc'
        ];


        $records2 = $model2->getRecords([], $orderBy);

        function getID($arr, $id)
        {
            $max = 0;
            // var_dump($arr) ;
            foreach($arr as $item){
                $item = $item[$id];
                
                $max =  max(substr($item,strrpos($item, "_25")+4), $max);
            }
            return $max + 1;
        }

        $IDCT[] = $records2[0][$configs2[0]['field']];
    
        $truoc = substr($IDCT[0],0, strrpos($IDCT[0], "_25")+4); 
        $sau = getID($records2, $configs2[0]['field']);
       
        $IDCT[0] =  $truoc. $sau ;
        //layID
        $date = Carbon::now('Asia/Ho_Chi_Minh');
        
        $modelName2 = 'ProductDetail';
        $model2 = '\App\Models\\'.ucfirst($modelName2); //ucfirst: auto làm chữ cái đầu in hoa
        $model2 = new $model2;
        $configs2 = $model2->editingConfigs();

        return view('admin.order-create',[
            'user'=> $admin,
            'employee' => $employee,
            'modelName' => $modelName,
            'configs' => $configs,
            'ID' => $ID,
            'date' => $date,
            'n' => 1,
            'configs2' => $configs2,
            'IDCT' => $IDCT
        ]);
    } 

    
    public function postConfirm(Request $request, $modelName, $id){
        if(isset($_POST['submit_confirm'])){

            try {
                $admin = Auth::guard('admin')->user();
                $model = '\App\Models\\'.ucfirst($modelName);
                $model = new $model;
        
                $modelName2 = 'ProductDetail';
                $model2 = '\App\Models\\'.ucfirst($modelName2); //ucfirst: auto làm chữ cái đầu in hoa
                $model2 = new $model2;
        
                $configs = $model->confirmConfigs();
                $configs2 = $model2->confirmConfigs();
                
                $model = $model->where('importOrderID', $id)->first();
                $model -> orderDate =  Carbon::now('Asia/Ho_Chi_Minh');
                $model -> isStored = true;
                $model -> save();
                $records2 = [];
                foreach($configs2 as $config){
                    $records2[$config['field']] = $request->{$config['field']};
                }
        
                
                for($i = 0; $i < count($records2[$configs2[0]['field']]); $i++)
                {
                    $model2 = '\App\Models\\'.ucfirst($modelName2); 
                    $model2 = new $model2;
        
                    $model2 = $model2->where('productDetailID', $records2['productDetailID'][$i])->first();
                    foreach($configs2 as $config){
                        $model2->{$config['field']} = $records2[$config['field']][$i];
                        
                    }
        
                    $model2 -> save();
                }
                Alert::success('Xác Nhận Đơn Hàng Thành Công', '');
                
            } catch (\Throwable $th) {
            Alert::warning('Xác Nhận Đơn Hàng Thất Bại', '');
            return redirect()->back()->withInput();;
            }
        }
        
        return  redirect()->route('admin.import',['model'=>$modelName]);
        
        // var_dump($records2);exit;

    }
    public function getConfirm(Request $request, $modelName, $id)
    {
        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();
        
        $model = '\App\Models\\'.ucfirst($modelName);
        $model = new $model;

        $modelName2 = 'ProductDetail';
        $model2 = '\App\Models\\'.ucfirst($modelName2); //ucfirst: auto làm chữ cái đầu in hoa
        $model2 = new $model2;

        $configs = $model->editingConfigs();
        $configs2 = $model2->confirmConfigs();

        $orderBy = [
            'field' => 'isStored',
            'sort'=> 'asc'
         ];

        $records = $model->where('importOrderID',$id)->first();
        $records2 = $model2->where('importOrderID',$id)->get();
        
        if($records -> isStored == true){
            return view('admin.error');
        }else
        // var_dump($records2);exit;
        return view('admin.order-confirm',[
            'user'=> $admin,
            'employee' => $employee,
            'modelName' => $modelName,
            'configs' => $configs,
            'configs2' => $configs2,
            'records' => $records,
            'records2' => $records2,
            'id' => $id
        ]);
    }

    public function postCreate(Request $request, $modelName, $n)
    {
        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();
        
        //Lấy dữ liệu từ db
        
        
        $model = '\App\Models\\'.ucfirst($modelName); //ucfirst: auto làm chữ cái đầu in hoa
        $model = new $model;
        // $editingConfigs = $model->editingConfigs();


        $modelName2 = 'ProductDetail';
        $model2 = '\App\Models\\'.ucfirst($modelName2); //ucfirst: auto làm chữ cái đầu in hoa
        $model2 = new $model2;
        // $editingConfigs2 = $model2->editingConfigs();
        
        $configs = $model->editingConfigs();
        $configs2 = $model2->editingConfigs();
        // var_dump($request->all());exit;
       //INSERT DATA
       $ID = "";
       $records = [];
       $record2 = [];
       $ID = $request->importOrderID;
           
        
        foreach($configs as $config){
            $records[$config['field']] = $request->{$config['field']};
        }
        foreach($configs2 as $config){
            $records2[$config['field']] = $request->{$config['field']};
        }

        $i = $n - 1;
        $IDCT = $records2['productDetailID'];
        // $IDCT[] = $records2[$configs[0]['field']];
        $IDCT[] = $IDCT[$i - 1];
        $sau = substr($IDCT[$i],strrpos($IDCT[$i], "_25")+4) + 1;
        $truoc = substr($IDCT[$i],0, strrpos($IDCT[$i], "_25")+4); 
        $IDCT[$i] =  $truoc. $sau ;

        
       if($request ->method() == "POST" && isset($_POST['submit_add']))
       {
            // foreach($configs as $config)
            // {
            //     if(!empty($config['validate']))
            //     {
            //         $arrValidateFields[$config['field']] = $config['validate'];   
            //     }
            // }
            // $validated = $request->validate($arrValidateFields);

            
           //var_dump($request);exit;
           $configs = $model->getAddConfigs();
           $configs2 = $model2 -> getAddConfigs();
           if($model ->addDataOrder($request, $modelName,$configs, $configs2, $records, $records2, $ID, $n)){
            Alert::success('Thêm Thành Công', '');
            return  redirect()->route('admin.import',['model'=>$modelName]);
           }else{
            //    echo "abc"; exit;
            Alert::error('Thêm Thất Bại', '');
            $date = Carbon::now('Asia/Ho_Chi_Minh');
            $configs = $model->editingConfigs();
            $configs2 = $model2->editingConfigs();
            return view('admin.order-create',[
                'user'=> $admin,
                'employee' => $employee,
                'modelName' => $modelName,
                'configs' => $configs,
                'configs2' => $configs2,
                // 'getDataCate' => $getDataCate,
                // 'getDataSupp' => $getDataSupp,
                'ID' => $ID,
                'date' => $date,
                'n' => $n -1 ,
                'records' => $records,
                'records2' => $records2,
                'IDCT' =>$IDCT
            ]);
           }
        //    unset($_POST['submit_add']);
       }
       
       else{//$request ->method() == "POST" && isset($_POST['addRow'])
           
        //    var_dump($records);exit;
       }
       $date = Carbon::now('Asia/Ho_Chi_Minh');
       return view('admin.order-create',[
        'user'=> $admin,
        'employee' => $employee,
        'modelName' => $modelName,
        'configs' => $configs,
        'configs2' => $configs2,
        // 'getDataCate' => $getDataCate,
        // 'getDataSupp' => $getDataSupp,
        'ID' => $ID,
        'date' => $date,
        'n' => $n,
        'records' => $records,
        'records2' => $records2,
        'IDCT' =>$IDCT
    ]);
    }

    public function getList(Request $request, $modelName, $id)
    {
        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();
        
        $model = '\App\Models\\'.ucfirst($modelName);
        $model = new $model;

        $modelName2 = 'ProductDetail';
        $model2 = '\App\Models\\'.ucfirst($modelName2); //ucfirst: auto làm chữ cái đầu in hoa
        $model2 = new $model2;

        $configs = $model->editingConfigs();
        $configs2 = $model2->confirmConfigs();

        $records = $model->where('importOrderID',$id)->first();
        $records2 = $model2->where('importOrderID',$id)->get();

        // var_dump($records[$config['field']]);exit;

        return view('admin.order-detail',[
            'user'=> $admin,
            'employee' => $employee,
            'modelName' => $modelName,
            'configs' => $configs,
            'configs2' => $configs2,
            'records' => $records,
            'records2' => $records2,
            'id' => $id
        ]);
    }
}

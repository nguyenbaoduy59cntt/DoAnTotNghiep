<?php
namespace App\Http\Controllers;

use App\Http\Middleware\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use MicrosoftAzure\Storage\Common\Internal\Validate;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Session\Session;

class EditingController extends Controller
{
    public function create(Request $request, $modelName)
    {
        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();
        
        $model = '\App\Models\\'.ucfirst($modelName); //ucfirst: auto làm chữ cái đầu in hoa
        $model = new $model;

        $configs = $model->editingConfigs(); //gọi hàm đã tạo bên model

        $getDataCate = $model ->getDataTableCate();
        $getDataSupp = $model ->getDataTableSupp();
        $getDataBranch = $model ->getDataTableBranch();


        $filterResult = $model->getFilter($request, $configs, $modelName);

        $orderBy = [
            // 'field' => strtolower($modelName).'ID',
            'field' => 'created_at',
            'sort'=> 'desc'
        ];

        // $records = $model->getRecords($filterResult['conditions'], $orderBy)[0];
        $records = $model->getRecords([], $orderBy)[0];
        
        $ID = $records[$configs[0]['field']];
         
        if($modelName == 'Product')
        {
            $sau = substr($ID,strrpos($ID, "_25")+4) + 1;
            $truoc = substr($ID,0, strrpos($ID, "_25")+4); 
            $ID =  $truoc. $sau ;
        }

        if($modelName == 'Supplier')
        {
            $sau = substr($ID,strrpos($ID, "_")+1)+1;
            $truoc = substr($ID,0, strrpos($ID, "_")+1);
            $ID =  $truoc. $sau;
        }

        if($modelName == 'Employee')
        {
            $sau = substr($ID,strrpos($ID, "_")+1)+1;
            $truoc = substr($ID,0, strrpos($ID, "_")+1);
            $ID =  $truoc. $sau;
        }
        

        return view('admin.create',[
            'user'=> $admin,
            'employee' => $employee,
            'modelName' => $modelName,
            'configs' => $configs,
            'getDataCate' => $getDataCate,
            'getDataSupp' => $getDataSupp,
            'getDataBranch' => $getDataBranch,
            'ID' => $ID
        ]);
    } 
    public function postCreate(Request $request, $modelName)
    {
        //Lấy dữ liệu từ db
        $model = '\App\Models\\'.ucfirst($modelName); //ucfirst: auto làm chữ cái đầu in hoa
        $model = new $model;
        $editingConfigs = $model->editingConfigs();

        $configs = $model->editingConfigs();
        $arrValidateFields = [];

        
        
        $tam = [];
        //INSERT DATA
        if($request ->method() == "POST" && isset($_POST['submit_add'])) //or là:  if($request ->method() == "POST" && isset(($request->all())['submit']))
        {
            foreach($configs as $config)
            {
                if(!empty($config['validate']))
                {
                    $arrValidateFields[$config['field']] = $config['validate'];   
                }
            }
            $validated = $request->validate($arrValidateFields);
            
            
            if($modelName == 'Category')
            {
                $cate_id = DB::table('categories')->select('categoryID')->get();
                $cate_id = $cate_id;
                $check = $request->categoryID;
                // var_dump($check);exit;
                foreach($cate_id as $item)
                {
                    // echo ($item -> categoryID);
                    if(in_array($check,(array)($item -> categoryID)))
                    {
                        unset($_POST['submit_add']);
                        Alert::error('Mã đã tồn tại', '');
                        return redirect()->back()->withInput();
                    }
                }
            }

            $a = $model -> saveDataError($request, $configs, $modelName);

            $model ->addData($request, $modelName,$editingConfigs);
            unset($_POST['submit_add']);
            Alert::success('Thêm Thành Công', '');
        }
        return  redirect()->route('listing.index',['model'=>$modelName]);
    }

    public function getEdit($modelName, $id)
    {
        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();
        
        $model = '\App\Models\\'.ucfirst($modelName); //ucfirst: auto làm chữ cái đầu in hoa
        $model = new $model;
        $configs = $model->editingConfigs();
        $tableName = $model->tableName;

        $key =substr($model->primaryKey,0);//ProductID
        
        $data =DB::table($tableName)->where($key, $id)->first();
        $getDataCate = $model ->getDataTableCate();
        $getDataSupp = $model ->getDataTableSupp();
        $getDataBranch = $model ->getDataTableBranch();
        
            
         return view('admin.editing', [
            'model'=> $modelName,
            'id' =>$id,
            'user'=> $admin,
            'employee' => $employee,
            'modelName' => $modelName,
            'change' => true,
            'data' =>$data,
            'configs' => $configs,
            'getDataCate' => $getDataCate,
            'getDataSupp' => $getDataSupp,
            'getDataBranch' => $getDataBranch
         ]);
    }

    public function postEdit(Request $request, $modelName, $id)
    {

        $admin = Auth::guard('admin')->user();
        $model = '\App\Models\\'.ucfirst($modelName);
        $model = $model::find($id);
        $configs = $model->editingConfigs();
        $tableName = $model->tableName;
        $key =substr($model->primaryKey,0);//ProductID

        $data =DB::table($tableName)->where($key, $id)->first();
         
        foreach($configs as $config){
            if($config['type'] != 'image' && $config['type'] != 'password')
                $model->{$config['field']} = $request->{$config['field']};
                elseif($config['type'] == "password"){
                    $model->{$config['field']} = Hash::make($request ->{$config['field']});
                }
            else{
                if(empty($request -> {$config['field']})){
                    $model -> {$config['field']}= $data -> {$config['field']};
                }
                else{
                    $fileName = $request->{$config['field']}->getClientOriginalName();
                    $request->{$config['field']}->move('../public/admin_images/product/', $fileName);
                    $model->{$config['field']} = $fileName;
                }
            }
        }
        $model->save();
        Alert::success('Dữ Liệu Đã Được Chỉnh Sửa', '');
        if($modelName == 'ProductDetail' ){
            $id = $data->productID;
            return redirect()->route('listingdetail.product',['id'=>$id]);
        }else
        return  redirect()->route('listing.index',['model'=>$modelName]);
    }

    public function delete(Request $request, $modelName, $id)
    {
        $admin = Auth::guard('admin')->user();
        $model = '\App\Models\\'.ucfirst($modelName); //ucfirst: auto làm chữ cái đầu in hoa
        $model = $model::find($id);

        $configs = $model->editingConfigs();
        $tableName = $model->tableName;
        $key =substr($model->primaryKey,0);//ProductID
        
        $data =DB::table($tableName)->where($key, $id)->first();
        
        if($model->tableName == 'products')
        {
            $abc = '../../public/admin_images/'.$model->productImage;
            if(file_exists($abc))
            {
                unlink($abc);
            }
        }
        $model->delete();
        Alert::success('Đã Xóa', '');
        if($modelName == 'ProductDetail' ){
            $id = $data->productID;
            return redirect()->route('listingdetail.product',['id'=>$id]);
        }else
        return  redirect()->route('listing.index',['model'=>$modelName]);
    }

    public function getDetail(Request $request, $modelName, $id)
    {
    // if(!empty(session('alert')))
    // {
    //     echo 'a';
    // }
    // else
    //     echo 'b';exit;

       $admin = Auth::guard('admin')->user();
       $employee = Auth::guard('employee')->user();
      
        $model = '\App\Models\\'.ucfirst($modelName); //ucfirst: auto làm chữ cái đầu in hoa
        $model = new $model;
        $configs = $model->editingConfigs();
       
        $tableName = $model->tableName;

        $key =substr($model->primaryKey,0);//ProductID
        
        $data =DB::table($tableName)->where($key, $id)->first();
        $getDataCate = $model ->getDataTableCate();
        $getDataSupp = $model ->getDataTableSupp();
        $getDataBranch = $model ->getDataTableBranch();

         return view('admin.detail', [
            'model'=> $modelName,
            'id' =>$id,
            'user'=> $admin,
            'employee' => $employee,
            'modelName' => $modelName,
            'change' => true,
            'data' =>$data,
            'configs' => $configs,
            'getDataCate' => $getDataCate,
            'getDataSupp' => $getDataSupp,
            'getDataBranch' => $getDataBranch
         ]);
    }
}

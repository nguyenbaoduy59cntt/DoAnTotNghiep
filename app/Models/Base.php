<?php
namespace App\Models;
use Aws\IoTDeviceAdvisor\IoTDeviceAdvisorClient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\PseudoTypes\False_;

class Base extends Model
{
    use HasFactory;

    public function getRecords($conditions, $orderBy)
    {
        $per_page = 5;
        return self::orderby($orderBy['field'], $orderBy['sort'])->where($conditions)->paginate($per_page)->withQueryString();
    }
  
    //Hiển thị configs ra danh sách

    public function orderConfigs()
    {
        return $this->getConfigs('order');
    }


    public function confirmConfigs()
    {
        return $this->getConfigs('confirm');
    }

    public function editingConfigs()
    {
        return $this->getConfigs('editing');
    }

    public function getAddConfigs()
    {
        return $this->getConfigs('add');
    }

    public function listingConfigs()
    {
        return $this->getConfigs('listing');
    }

    public function getConfigs($interface)
    {
        $configs = $this->configs();
        $result = [];
        foreach($configs as &$config)
        {
            if(!empty($config[$interface]) && $config[$interface] == true)
            {
                $result[] = $config;
            }
        }
        // var_dump($result);exit;

        return $result;
    }

    //Hàm get data table
    public function getDataTableCate()
    {
        $data = DB::table('categories')
            ->get();
        return $data;
    }

    public function getDataTableSupp()
    {
        $data = DB::table('suppliers')
            ->get();

        return $data;
    }

    public function getDataTableBranch()
    {
        $data = DB::table('branches')
            ->get();

        return $data;
    }

    //lưu lại dữ liệu khi post bị lỗi
    public function saveDataError($request, $configs, $modelName)
    {
        $temporary = [];
        if($request->method() == "POST" )
        {
            foreach ($configs as &$config) 
            {
                if (!empty($config['editing']))
                {
                    $value =  $request->input($config['field']);

                    $temporary[] = [
                        'field' => $config['field'],
                        'where' => '=',
                        'value' => $value
                    ];
                    $config['temporary'] = $value;
                } 
            }
            // return redirect()->back()->withInput();
        }
    }

    //Bộ lọc
    public function getFilter($request, $configs, $modelName)
    {
        $conditions = [];
        // echo isset($request->all()['page']) ? 'co': 'khong';
        if ($request->method() == "POST") 
        {
            foreach ($configs as &$config) {
                if (!empty($config['filter'])) 
                {
                    $value =  $request->input($config['field']);

                    switch ($config['filter']) 
                    {
                        case "equal":
                            if (!empty($value)) {
                                $conditions[] = [
                                    'field' => $config['field'],
                                    'where' => '=',
                                    'value' => $value
                                ];
                                $config['filter_value'] = $value;
                            }
                            break;

                        case "like":
                            if (!empty($value)) {
                                $conditions[] = [
                                    'field' => $config['field'],
                                    'where' => 'like',
                                    'value' => '%' . $value . '%'
                                ];
                                $config['filter_value'] = $value;
                            }

                            break;

                        case "between":
                            if (!empty($value['from'])) {
                                $conditions[] = [
                                    'field' => $config['field'],
                                    'where' => '>=',
                                    'value' => $value['from']
                                ];
                                $config['filter_from_value'] = $value['from'];
                            }
                            if (!empty($value['to'])) {
                                $conditions[] = [
                                    'field' => $config['field'],
                                    'where' => '<=',
                                    'value' => $value['to']
                                ];
                                $config['filter_to_value'] = $value['to'];
                            }
                            break;
                    }
                }
            }
            Cookie::queue(strtolower($modelName) . '_filter', json_encode($conditions), 24 * 60); //json_encode($conditions): chuyển mảng thành chuỗi, cooki lưu trong 24h
        } 
        else //method : GET
        if(isset($request->all()['page']))
        {
            $conditions  = json_decode(Cookie::get(strtolower($modelName) . '_filter'));

            if (!empty($conditions)) 
            {
                // var_dump($conditions);exit;
                foreach ($conditions as &$condition) 
                {
                    $condition = (array)$condition;
                    // var_dump($conditions);exit;
                    foreach ($configs as &$config) {
                        if ($config['field'] == $condition['field']) {
                            switch ($config['filter']) {
                                case "equal":
                                    $config['filter_value'] = $condition['value'];
                                    break;
                                case "like":
                                    $config['filter_value'] = str_replace("%", "", $condition['value']);
                                    //$config['filter_value'] = $condition['value'];
                                    break;
                                case "between":
                                    // var_dump($condition);exit;
                                    if ($condition['where'] == ">=") {
                                        $config['filter_from_value'] = $condition['value'];
                                    } else {
                                        $config['filter_to_value'] = $condition['value'];
                                    }
                                    break;
                            }
                        }
                    }
                }
            }
        }
        else{
            Cookie::queue(Cookie::forget(strtolower($modelName) . '_filter'));
        }
        // if(isset())
        return array(
            'conditions' => $conditions,
            'configs' => $configs
        );
    }

    
    // Thống kê sản phẩm có số lượng gần hết hoặc đã hết

    public function getFilterStatistic()
    {
        $arrayfilterResultStatistic = [];
        //$records2 là số lượng tối thiểu
        // var_dump($records);exit;
        $arrayfilterResultStatistic[] = DB::table('product_details')
                    ->join('products', 'product_details.productID', '=', 'products.productID') 
                    ->select('product_details.productID', DB::raw('SUM(quantityPerUnit) as total'), 'minimum_stock_quantity','productName')  
                    ->groupBy('product_details.productID')
                    ->havingRaw('SUM(quantityPerUnit) < minimum_stock_quantity' )
                    ->get();

        //records là số ngày tồn kho
        $arrayfilterResultStatistic[] = DB::table('product_details')
                    ->join('products', 'product_details.productID', '=', 'products.productID') 
                    ->join('import_orders', 'product_details.importOrderID', '=', 'import_orders.importOrderID')
                    ->whereRaw("DATEDIFF('" . Carbon::now('Asia/Ho_Chi_Minh') . "',orderDate)  >= maximum_stock_date")
                    ->get();

        // var_dump($records2);exit;
            
        //$records3 là hết hạn
        $arrayfilterResultStatistic[] = DB::table('product_details')
                    ->join('import_orders', 'product_details.importOrderID', '=', 'import_orders.importOrderID')
                    ->join('products', 'product_details.productID', '=', 'products.productID') 
                    ->whereRaw("DATEDIFF('" . Carbon::now('Asia/Ho_Chi_Minh') . "',expiry_date)  >= 0")
                    ->get();

        // var_dump($arrayfilterResultStatisticImport);exit;
            
       
        return $arrayfilterResultStatistic;
    }

    

    //Đẩy dữ liệu ra dashboard để thông báo 
    public function dashboard_statistics()
    {
        
        
        try{
            $array_dashboard_statistics = [];
            $array_dashboard_statistics[0] = DB::table('product_details')
            ->join('products', 'product_details.productID', '=', 'products.productID') 
            ->select('product_details.productID', DB::raw('SUM(product_details.quantityPerUnit) as total'), 'minimum_stock_quantity','productName')  
            ->groupBy('product_details.productID')
            ->havingRaw('SUM(product_details.quantityPerUnit) < minimum_stock_quantity' )
            ->get();

//records là số ngày tồn kh
$array_dashboard_statistics[1] = DB::table('product_details')
            ->join('products', 'product_details.productID', '=', 'products.productID') 
            ->join('import_orders', 'product_details.importOrderID', '=', 'import_orders.importOrderID')
            ->whereRaw("DATEDIFF('" . Carbon::now('Asia/Ho_Chi_Minh') . "',orderDate)  >= maximum_stock_date")
            ->get();

// var_dump($records2);exit;
    
//$records3 là hết hạn
$array_dashboard_statistics[2] = DB::table('product_details')
            ->join('import_orders', 'product_details.importOrderID', '=', 'import_orders.importOrderID')
            ->join('products', 'product_details.productID', '=', 'products.productID') 
            ->whereRaw("DATEDIFF('" . Carbon::now('Asia/Ho_Chi_Minh') . "',expiry_date)  >= 0")
            ->get();


$record0 = count($array_dashboard_statistics[0]);
$record1 = count($array_dashboard_statistics[1]);
$record2 = count($array_dashboard_statistics[2]);

return [$record0, $record1, $record2];
        }
        catch (\Throwable $th) {
            return [0,0,0];
        }
    }

    //Thêm dữ liệu vào db
    public function addData($request, $modelName, $editingConfigs)
    {
        $dt =  Carbon::now('Asia/Ho_Chi_Minh');

        $url = 'App\Models\\';
        $model = $url.$modelName;
        $dataTable = new $model;
        // var_dump($editingConfigs);exit;
        foreach($editingConfigs as &$editingConfig)
        {
            if($editingConfig['type'] == "password"){
                $dataTable->{$editingConfig['field']} = Hash::make($request ->{$editingConfig['field']});
            }
            if($editingConfig['type'] == "number")
            {
                $dataTable->{$editingConfig['field']} = $request ->{$editingConfig['field']};
                
            }
            if($editingConfig['type'] == 'text' || $editingConfig['type'] == 'ckediter' ||  $editingConfig['type'] == 'option')
            {
                $dataTable->{$editingConfig['field']} = $request ->{$editingConfig['field']};
            }
            if($editingConfig['type'] == 'image')
            {
                $fileName = request()->{$editingConfig['field']}->getClientOriginalName();
                request()->{$editingConfig['field']}->move('../public/admin_images/product/', $fileName);
                $dataTable->{$editingConfig['field']} = $fileName;
            }
            
            if($editingConfig['field'] == 'updated_at' || $editingConfig['field'] == 'created_at' ||$editingConfig['field'] == 'orderDate')
            {
                $dataTable->{$editingConfig['field']} = $dt;
            }
        }
        $dataTable->save();
    }

    
    public function addDataOrder($request, $modelName, $configs, $configs2, $records, $records2, $ID, $n)
    {
        $dt =  Carbon::now('Asia/Ho_Chi_Minh');
        $n--;
        $url = 'App\Models\\';
        $model = $url.$modelName;
        $dataTable = new $model;
        // var_dump($records);exit;
        
        foreach($configs as $config){
            if($config['type'] != "ID" && empty($records[$config['field']]))
            {
                return false;
            }
        }

        $arr = [];
        for($i = 0; $i < $n; $i++){
            foreach($configs2 as $config){
                    // var_dump($config);
                    if($config['field'] == 'productID'){
                        // echo"ok";exit;
                        if(!inArr($records2[$config['field']][$i], $arr)){
                            $arr[] = $records2[$config['field']][$i];
                        }
                        else return false;
                    }
            }
        }

        for($i = 0; $i < $n; $i++){
            foreach($configs2 as $config){
                if($config['type'] != "ID" && empty($records2[$config['field']][$i]))
                {
                    // var_dump($configs2);exit;
                    if($config['field'] == 'productID'){
                        echo"ok";exit;
                        if(!inArr($records2[$config['field']][$i], $arr)){
                            $arr[] = $records2[$config['field']][$i];
                        }
                        else return false;
                    }
                    return false;
                }
            }
        }
        

        foreach($configs as &$config)
        {
            
            if($config['type'] == "number")
            {
                $dataTable->{$config['field']} = $records[$config['field']];
            }
            if($config['type'] == 'text' || $config['type'] == 'ckediter' ||  $config['type'] == 'option')
            {
                // echo $records ->{$config['field']}; exit;
                $dataTable->{$config['field']} = $records[$config['field']];
            }
            
        }
        // var_dump($dataTable);exit;
        try {
            if($dataTable->save()) {
            
                $model = $url.'ProductDetail';
        
                for($i = 0; $i < $n; $i++){
                    $dataTable = new $model;
                    foreach($configs2 as $config){
                        if($config['type'] == "number")
                        {
                            $dataTable->{$config['field']} = $records2[$config['field']][$i];
                        }
                        if($config['type'] == 'text' || $config['type'] == 'ckediter' ||  $config['type'] == 'option')
                        {
                            $dataTable->{$config['field']} = $records2[$config['field']][$i];
                        }
                        if($config['type'] == "ID")
                        {
                            $dataTable->{$config['field']} = $ID;
                        }
                    }
                    $dataTable->save();
                }
                };
        } catch (\Throwable $th) {
            return false;
        }
        return true;
        
    }

    public function getEdit($modelID)
    {
       
        $ma = Product::find($modelID);
        var_dump($ma);exit;
        return view('admin.listing',[
            'ma' => $ma
        ]);
    }


    public function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    //Chỉ khai báo các trường chắc chắn có
    public function defaultListingConfigs()
    {
        return array(
            array(
                'field' => "updated_at",
                'name' => 'Ngày cập nhật',
                'type' => 'text',
                'sort' => true,
                'listing' => true,
                'editing' => false
            ),

            array(
                'field' => "created_at",
                'name' => 'Ngày tạo',
                'type' => 'text',
                'sort' => true,
                'listing' => true,
                'editing' => false
            ),

            array(
                'field' => "detail",
                'name' => 'Chi tiết',
                'type' => 'detail',
                'listing' => true,
                'editing' => false
            ),

            array(
                'field' => "edit",
                'name' => 'Sửa',
                'type' => 'edit',
                'listing' => true,
                'editing' => false,
                'admin' =>true
            ),
            array(
                'field' => "delete",
                'name' => 'Xóa',
                'type' => 'delete',
                'listing' => true,
                'editing' => false,
                'admin' =>true
            ),
        );
    }
}

function inArr($s, $arr){
    for($i = 0; $i < count($arr); $i++){
        if($s == $arr[$i]) return true;
    }
    return false;
}
<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
//Thêm thư viện Auth vô
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class AdminController extends Controller
{
    
    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials) || Auth::guard('employee')->attempt($credentials))
        {
            return redirect()->route('admin.dashboard');
        }
        else 
        {
            $login = false;
            return view('admin.login', [
                'login' => $login
            ]);
        }
    }

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();


        $model = '\App\Models\Statistics';
        $model = new $model;

        $records = [];
        $value = [];
        $records = $model->dashboard_statistics();
        foreach($records as $record)
        {
            $value[] =  $record;
            
        }
        return view('admin.dashboard', [
                'user' => $admin,
                'employee' => $employee,
                'record0' => $value[0],
                'record1' => $value[1],
                'record2' => $value[2],
            ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    
    //Làm Thống Kê
    public function statistics(Request $request, $n)
    {
        // $this->authorize('admin');
        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();

        $model = '\App\Models\Statistics';
        $model = new $model;
        $configs = $model->statistics($n);

        $records = [];
        $arrayfilterResultStatistic = $model->getFilterStatistic();

        if (strlen(strstr(url()->current(), "0")) >0) 
        {
            $title = "Danh Sách Mặt Hàng Sắp Hết";
            $records = $arrayfilterResultStatistic[$n];
        }else
        if (strlen(strstr(url()->current(), "1")) >0) 
        {
            $title = "Danh Sách Mặt Hàng Tồn Kho";
            $records = $arrayfilterResultStatistic[$n];
        }else
        if (strlen(strstr(url()->current(), "2")) >0) 
        {
            $title = "Danh Sách Mặt Hàng Hết Hạn Sử Dụng";
            $records = $arrayfilterResultStatistic[$n];
        }

        return view('admin.statistics', [
            'user' => $admin,
            'employee' => $employee,
            'configs' => $configs,
            'records' => $records,
            'title' => $title,
            'n' => $n
        ]);
    }

    //Xuất PDF
    public function prints(Request $request,$n)
    {
        $pdf = \App::make('dompdf.wrapper');

        // echo'abc';exit;
        $pdf ->loadHTML($this->print_convert($n));
        return $pdf -> stream();
    }

    public function print_convert($n)
    {
        if($n == 0)
            $title = "<p style=\" text-align: center; font-size: 13px \">Danh Sách Mặt Hàng Sắp Hết</p>";
        else
        if($n == 1)
            $title = "<p style=\" text-align: center; font-size: 13px \">Danh Sách Mặt Hàng Tồn Kho</p>";
        else
            $title = "<p style=\" text-align: center; font-size: 13px \">Danh Sách Mặt Hàng Hết Hạn Sử Dụng</p>";


        $admin = Auth::guard('admin')->user();
        $employee = Auth::guard('employee')->user();

        // var_dump($employee);exit;

        $dateTime =  Carbon::now('Asia/Ho_Chi_Minh');

        $model = '\App\Models\Product';
        $model = new $model;
        $configs = $model->statistics($n);
        
        $arrayfilterResultStatisticImport = $model->getFilterStatistic();
        $records = $arrayfilterResultStatisticImport[$n];
       
        $mega = "<p style=\" text-align: center; font-size: 15px \">MM Mega MarKet Việt Nam</p>";
        $store = "<p style=\" text-align: center \">Store Nha Trang</p>";

        if(Auth::guard('admin')->check() == true)
            $adminName = "Tên quản trị viên: ".$admin->name;
        else
            $adminName = "Tên quản trị viên: ".$employee->lastName.' '.$employee->firstName;

        $timePrint = "Thời gian in: ".$dateTime;
        $space = "<br/>";

        $style = '';
        
        $style .= '<style>
        body{
            font-family: Dejavu Sans;
            font-size: 10px;
        }
        </style>';
      
        $str = "<table class=\"table table-bordered\" style=\"border: 1px solid black; align: center; width: 100%;\">";     
        $str1 = "<tr >";    
        
        foreach($records[0] as $key => $value)
        {
            if($key == 'productID' || $key == 'productName' || $key == 'quantityPerUnit' || $key == 'total'|| $key == 'productDetailID' || $key == 'expiry_date'  )
            {
                if($key == 'productID')
                    $key = 'Mã sản phẩm';
                if($key == 'productName')
                    $key = 'Tên sản phẩm';
                if($key == 'quantityPerUnit')
                    $key = 'Số lượng sản phẩm';
                if($key == 'total')
                    $key = 'Số lượng còn lại';
                if($key == 'productDetailID')
                    $key = 'Mã chi tiết';
                if($key == 'expiry_date')
                    $key = 'Hạn sử dụng';
                    
                $str1 = $str1 . "<th scope=\"col\">".strval($key) ."</th>"; 
            }
        }
        $str = $str .$str1. "</tr style=\"border: 1px solid black;\">";
        
        foreach($records as &$record)
        {
            $str1 = "<tr>";
            foreach($record as $key => $value)
            {
                if($key == 'productID' || $key == 'productName' || $key == 'quantityPerUnit' || $key == 'total'|| $key == 'productDetailID' || $key == 'expiry_date' )
                {
                    $str1 = $str1 . "<td >".strval($value) ."</td>"; 
                }
            }
            $str = $str .$str1. "</tr>";
        }

        $str = $str . "</table>";
        return $mega
                .$space
                .$store
                .$space
                .$style
                .$timePrint
                .$space
                .$adminName
                .$space
                .$title
                .$space
                .$space
                .$str;
    }


    public function import(Request $request, $modelName)
    {
        $title = 'Quản Lý Đơn Hàng Nhập';

        $employee = Auth::guard('employee')->user();
        $admin = Auth::guard('admin')->user();


        $model = '\App\Models\\'.ucfirst($modelName); //ucfirst: auto làm chữ cái đầu in hoa
        $model = new $model;
        $configs = $model->orderConfigs();

        $filterResult = $model->getFilter($request, $configs, $modelName);

        $orderBy = [
            'field' => 'isStored',
            'sort'=> 'asc'
         ];

        $records = $model->getRecords($filterResult['conditions'], $orderBy);
        $modelID = 'importOrderID';
        return view('admin.order', [
            'user'=> $admin,
            'employee' => $employee,
            'title' => $title,
            'configs' => $configs,
            'records' => $records,
            'modelName' => $modelName,
            'orderBy' => $orderBy,
            'modelID' => $modelID
        ]);
    }
}

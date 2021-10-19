<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportOrder extends Base
{
    use HasFactory;

    public $title = "Danh sách đơn hàng nhập";
    public $primaryKey = 'importOrderID';
    public $tableName = 'import_orders';
    public $incrementing = false;

    public function configs()
    {

        $defaultListingConfigs = parent::defaultListingConfigs();

        $listingConfigs = array(
            
            array(
                'field' =>'importOrderID',
                'name' => 'Mã đơn hàng nhập',
                'type' => 'text',
                'filter' => 'equal',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'ID' =>true,
                'order'=>true,
                'add' =>true
            ),

            array(
                'field' => "employeeID",
                'name' => 'Mã nhân viên',
                'type' => 'text',
                'filter' => 'like',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'order'=>true,
                'add' =>true,
                'readonly' =>true,
                'validate' => 'required',
            ),

            array(
                'field' => "orderDate",
                'name' => 'Ngày nhập',
                'type' => 'date',
                'listing' => true,
                'order' =>true,
                'editing' => true
            ),

            array(
                'field' => "isStored",
                'name' => 'Xác nhận',
                'type' => 'confirm',
                'listing' => true,
                'order' =>true,
                'editing' => false
            ),

            array(
                'field' => "detail",
                'name' => 'Chi tiết đơn hàng',
                'type' => 'list',
                'listing' => true,
                'order' =>true,
                'editing' => false
            ),


        );
        return array_merge($listingConfigs, $defaultListingConfigs);
}
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Base
{
    use HasFactory;

    public $title = "Danh Sách Chi Tiết Sản Phẩm";
    public $primaryKey = 'productDetailID';
    public $tableName = 'product_details';
    public $incrementing = false;
    public function configs()
    {
        $defaultListingConfigs = parent::defaultListingConfigs();

        $listingConfigs = array(

            array(
                'field' =>'productDetailID',
                'name' => 'Mã chi tiết',
                'type' => 'text',
                'filter' => 'equal',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'order'=>true,
                'add' =>true,
                'ID' => true,
                'readonly' =>true,
                'confirm' => true
            ),

            array(
                'field' =>'productID',
                'name' => 'Mã sản phẩm',
                'type' => 'text',
                'filter' => 'equal',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'order'=>true,
                'add' =>true,
                'readonly' =>true,
                'confirm' => true,
                'validate' => 'required|max:255',
            ),

            array(
                'field' =>'importOrderID',
                'name' => 'Mã đơn hàng nhập',
                'type' => 'ID',
                'filter' => 'equal',
                'listing' => false,
                'editing' => false,
                //adding
                'add' => true,
                'readonly' =>true

            ),

            array(
                'field' => "quantityPerUnit",
                'name' => 'Số lượng',
                'type' => 'number',
                'listing' => true,
                'editing' => true,
                'add' =>true,
                'readonly' =>true,
                'confirm' => true,
                'validate' => 'required|numeric',
            ),

            array(
                'field' => "discount",
                'name' => 'Giảm giá(%)',
                'type' => 'number',
                'listing' => false,
                'editing' => false,
                'confirm' => true
            ),

            array(
                'field' =>"date_of_manufacture",
                'name' => 'Ngày sản xuất',
                'type' => 'date',
                'listing' => false,
                'editing' => false,
                'order'=>true,
                'confirm' => true,
                'validate' => 'required',
            ),

            array(
                'field' =>"expiry_date",
                'name' => 'Hạn sử dụng',
                'type' => 'date',
                'listing' => false,
                'editing' => false,
                'order'=>true,
                'confirm' => true,
                'validate' => 'required',
            ),
        );
        return array_merge($listingConfigs, $defaultListingConfigs);
    }
}

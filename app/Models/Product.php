<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base;

class Product extends Base
{
    use HasFactory;

    public $title = "Danh Sách Sản Phẩm";
    public $primaryKey = 'productID';
    public $tableName = 'products';
    public $incrementing = false;
    public function configs()
    {
        $defaultListingConfigs = parent::defaultListingConfigs();

        $listingConfigs = array(
            
            array(
                'field' =>'productID',
                'name' => 'Mã sản phẩm',
                'type' => 'text',
                'filter' => 'equal',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'ID' =>true,
                'order'=>true
            ),
        

            array(
                'field' => "productName",
                'name' => 'Tên sản phẩm',
                'type' => 'text',
                'filter' => 'like',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'order'=>true,
                'validate' => 'required|max:255',
            ),

            array(
                'field' => "productImage",
                'name' => 'Ảnh sản phẩm',
                'type' => 'image',
                'listing' => true,
                'editing' => true,
                'validate' => 'required',
            ),

            array(
                'field' => "unit",
                'name' => 'Đơn vị tính',
                'type' => 'text',
                'listing' => true,
                'editing' => true,
                'forein' =>true,
                'validate' => 'required|max:255',
            ),


            array(
                'field' => "unitPrice", //Đây là tên các trường của bảng sản phẩm trong mysql
                'name' => 'Giá sản phẩm (VNĐ)',
                'type' => 'number',
                'filter' => 'between',
                'listing' => true,
                'editing' => true,
                'validate' => 'required|numeric',
            ),

            array(
                'field' => "description", //Đây là tên các trường của bảng sản phẩm trong mysql
                'name' => 'Mô tả sản phẩm',
                'type' => 'ckediter',
                'listing' => false,
                'editing' => true,
                'validate' => 'required',
            ),

            array(
                'field' =>"maximum_stock_date",
                'name' => 'Số ngày tồn kho tối đa',
                'type' => 'text',
                'listing' => false,
                'editing' => true,
                'order'=>true,
                'validate' => 'required|numeric',
                
            ),

            array(
                'field' =>"minimum_stock_quantity",
                'name' => 'Số lượng tồn kho tối thiểu',
                'type' => 'text',
                'listing' => false,
                'editing' => true,
                'order'=>true,
                'validate' => 'required|numeric',
            ),

            array(
                'field' =>"categoryID",
                'name' => 'Danh mục sản phẩm',
                'type' => 'option',
                'listing' => false,
                'editing' => true,
                'table' => 'categories',
                'order'=>true,
                'validate' => 'required',
            ),

            array(
                'field' => "supplierID",
                'name' => 'Mã nhà cung cấp',
                'type' => 'option',
                'listing' => false,
                'editing' => true,
                'table' => 'suppliers',
                'filter' => 'equal',
                'validate' => 'required',
            ),

            array(
                'field' => "listingDetailProduct",
                'name' => 'Danh sách chi tiết',
                'type' => 'show-detail',
                'listing' => true,
                'editing' => false
            ),
        );
        return array_merge($listingConfigs, $defaultListingConfigs);
    }

    public function statistics()
    {
        $statistics = array(
            array(
                'field' =>'productID',
                'name' => 'Mã',
                'type' => 'text',
                'filter' => 'equal',
                
            ),

            array(
                'field' => "productName",
                'name' => 'Tên sản phẩm',
                'type' => 'text',
                'filter' => 'like',
                
            ),

            array(
                'field' => "quantityPerUnit",
                'name' => 'Số lượng',
                'type' => 'numberquan',
                
            ),
        );
        return $statistics;
    }
}



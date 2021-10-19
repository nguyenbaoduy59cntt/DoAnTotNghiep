<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base;

class Supplier extends Base
{
    use HasFactory;

    public $title = "Danh Sách Các Nhà Cung Cấp"; 
    public $primaryKey = 'supplierID';
    public $tableName = 'suppliers';
    public $incrementing = false;
    public function configs()
    {
        $defaultListingConfigs = parent::defaultListingConfigs();

        $listingConfigs = array(
            array(
                'field' =>'supplierID',
                'name' => 'Mã NCC',
                'type' => 'text',
                'filter' => 'equal',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'ID' =>true,
            ),

            array(
                'field' => "supplierName",
                'name' => 'Tên NCC',
                'type' => 'text',
                'filter' => 'like',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'validate' => 'required|max:255',
            ),

            array(
                'field' =>'address',
                'name' => 'Địa chỉ',
                'type' => 'text',
                'sort' => true,
                'listing' => false,
                'editing' => true,
                'validate' => 'required|max:255',
            ),

            array(
                'field' =>'fax',
                'name' => 'Số FAX',
                'type' => 'text',
                'listing' => false,
                'editing' => true,
                'validate' => 'required|numeric',
            ),

            array(
                'field' =>'phone',
                'name' => 'Số điện thoại',
                'type' => 'text',
                'listing' => false,
                'editing' => true,
                'validate' => 'required|numeric',
            ),

            array(
                'field' =>'email',
                'name' => 'Email',
                'type' => 'text',
                'listing' => false,
                'editing' => true,
                'validate' => 'required|email:rfc,dns',
            ),

            array(
                'field' => "listingProduct",
                'name' => 'Danh sách sản phẩm',
                'type' => 'show-product',
                'listing' => true,
                'editing' => false
            ),
        );

        return array_merge($listingConfigs, $defaultListingConfigs);
    }
}

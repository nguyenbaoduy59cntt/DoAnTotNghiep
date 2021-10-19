<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base;

class Statistics extends Base
{
    use HasFactory;

    public $title = "Danh sách";
    public function configs($n)
    {
        $defaultListingConfigs = parent::defaultListingConfigs();

        $listingConfigs = array();
        return array_merge($listingConfigs, $defaultListingConfigs);
    }

    public function statistics($n)
    {
        $statistics = [];

        //còn ít
        $statistics[] = array(
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
                'field' => "total",
                'name' => 'Số lượng còn lại',
                'type' => 'numberquan',
            ),
        );

        //tồn kho
        $statistics[] = array(
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
                'field' => "productDetailID",
                'name' => 'Mã chi tiết',
                'type' => 'text',
            ),

            array(
                'field' => "quantityPerUnit",
                'name' => 'Số lượng còn lại',
                'type' => 'numberquan',
            ),
            array(
                'field' => "maximum_stock_date",
                'name' => 'Ngày tối đa',
                'type' => 'numberquan',
            ),
        );

        //mặt hàng hết hạn
        $statistics[] = array(
            array(
                'field' =>'productID',
                'name' => 'Mã sản phẩm',
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
                'field' => "productDetailID",
                'name' => 'Mã chi tiết',
                'type' => 'text',
            ),

            array(
                'field' => "expiry_date",
                'name' => 'Ngày hết hạn',
                'type' => 'date',
            ),
        );
        return $statistics[$n];
    }
}



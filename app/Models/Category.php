<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base;;

class Category extends Base
{
    use HasFactory;

    public $title = "Danh Mục Sản Phẩm";
    public $primaryKey = 'categoryID';
    public $tableName = 'categories';
    public $incrementing = false;
    public function configs()
    {
        $defaultListingConfigs = parent::defaultListingConfigs();

        $listingConfigs = array(
            array(
                'field' =>'categoryID',
                'name' => 'Mã danh mục',
                'type' => 'text',
                'filter' => 'equal',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'validate' => 'required|max:255',
            ),

            array(
                'field' => "categoryName",
                'name' => 'Tên danh mục',
                'type' => 'text',
                'filter' => 'like',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'validate' => 'required|max:255',
            ),

            array(
                'field' => "description",
                'name' => 'Mô tả danh mục',
                'type' => 'ckediter',
                'listing' => false,
                'editing' => true,
                'validate' => 'required',
            ),
        );
        return array_merge($listingConfigs, $defaultListingConfigs);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Employee extends Base implements AuthenticatableContract
{
    use HasFactory;
    use Authenticatable;

    public $title = "Danh Sách Nhân Viên";
    public $primaryKey = 'employeeID';
    public $tableName = 'employees';
    public $incrementing = false;

    public function configs()
    {
        $defaultListingConfigs = parent::defaultListingConfigs();

        $listingConfigs = array(
            array(
                'field' =>'employeeID',
                'name' => 'Mã NV',
                'type' => 'text',
                'filter' => 'equal',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'ID' =>true,
            ),

            array(
                'field' => "lastName",
                'name' => 'Họ',
                'type' => 'text',
                'filter' => 'like',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'validate' => 'required|max:255',
            ),

            array(
                'field' => "firstName",
                'name' => 'Tên',
                'type' => 'text',
                'filter' => 'like',
                'sort' => true,
                'listing' => true,
                'editing' => true,
                'validate' => 'required|max:255',
            ),

            array(
                'field' => "email",
                'name' => 'Email',
                'type' => 'text',
                'listing' => true,
                'editing' => true,
                'validate' => 'required|email:rfc,dns',
            ),

            array(
                'field' => "password",
                'name' => 'Mật khẩu',
                'type' => 'password',
                'listing' => false,
                'editing' => true,
                'validate' => 'required|numeric',
            ),

            array(
                'field' => "image",
                'name' => 'Ảnh',
                'type' => 'image',
                'listing' => true,
                'editing' => true,
                'validate' => 'required|mimes:jpg,bmp,png',
            ),

            array(
                'field' => "birthDay",
                'name' => 'Năm sinh',
                'type' => 'option',
                'listing' => false,
                'editing' => true,
                'table' => 'birthDay',
                'validate' => 'required',
            ),

            array(
                'field' => "gender",
                'name' => 'Giới tính',
                'type' => 'option',
                'listing' => false,
                'editing' => true,
                'table' => 'gender',
                'validate' => 'required',
            ),

            array(
                'field' => "identityCard",
                'name' => 'Số CMND',
                'type' => 'text',
                'listing' => false,
                'editing' => true,
                'validate' => 'required|numeric',
            ),
            array(
                'field' => "address",
                'name' => 'Địa chỉ',
                'type' => 'text',
                'listing' => false,
                'editing' => true,
                'validate' => 'required|max:255',
            ),
            array(
                'field' => "phone",
                'name' => 'Số điện thoại',
                'type' => 'text',
                'listing' => false,
                'editing' => true,
                'validate' => 'required|numeric',
            ),

            array(
                'field' => "level",
                'name' => 'Level',
                'type' => 'option',
                'listing' => true,
                'editing' => true,
                'table' => 'level',
                'filter' => 'equal',
                'validate' => 'required',
            ),

            array(
                'field' => "branchID",
                'name' => 'Chi nhánh',
                'type' => 'option',
                'listing' => false,
                'editing' => true,
                'table' => 'branches',
                'validate' => 'required',
               
            ),
        );
        return array_merge($listingConfigs, $defaultListingConfigs);
    }
}

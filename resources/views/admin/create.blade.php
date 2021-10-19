@extends('layouts.admin')
@section('content')

<div class="">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> Tạo mới </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form class="form-horizontal form-label-left" method="post" action="{{route('editing.postCreate',['model'=>$modelName])}}" enctype="multipart/form-data">
                @csrf  <!-- token -->
                    <?php
                    if (!empty($configs)) {
                        foreach ($configs as $config) {
                            switch ($config['type']) {
                                case 'password':
                                case 'text':
                                    $field = $config['field'];
                        
                                    if(!empty($config['ID'])){
                    ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="<?= $config['field'] ?>" value='<?=$ID?>' readonly class="form-control">
                                            
                                        </div>
                                    </div>
                                <?php
                                    break;}
                                else {
                                    ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="<?= $config['field'] ?>" class="form-control" value="<?= (!empty($config['temporary'])) ? $config['temporary'] : "" ?>" placeholder="<?= htmlspecialchars($config['name']) ?> "  class="@error($field) is-invalid @enderror">
                                            @error($field)
                                                <?php
                                                switch($field)
                                                {
                                                    case 'supplierName':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập tên nhà cung cấp!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'address':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập địa chỉ!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'fax':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập số FAX!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'phone':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập số điện thoại!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'email':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập email!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'categoryID':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập mã danh mục sản phẩm!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'categoryName':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập tên danh mục sản phẩm!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'productName':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập tên sản phẩm!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'productImage':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng chọn ảnh!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'unit':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập đơn vị sản phẩm!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'unitPrice':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập đơn giá sản phẩm!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'maximum_stock_date':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập số ngày tồn kho tối đa!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'minimum_stock_quantity':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập số tượng tồn kho tối thiểu!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'lastName':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập họ!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'firstName':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập tên!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'password':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập mật khẩu!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'identityCard':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập số chứng minh nhân dân!' }}</div> 
                                                        <?php
                                                        break;
                                                }
                                                ?>
                                                
                                            @enderror
                                        </div>
                                    </div>
                                <?php
                                    break;
                            
                                }
                                case 'number':
                                $field = $config['field'];
                                ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" value="<?= (!empty($config['temporary'])) ? $config['temporary'] : "" ?>" name="<?= $config['field'] ?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>" class="@error($field) is-invalid @enderror">
                                            @error($field)
                                            <?php
                                            switch($field)
                                                {
                                                    case 'unitPrice':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập đơn giá!' }}</div> 
                                                        <?php
                                                        break;
                                                    }?>
                                            @enderror
                                        </div>
                                    </div>
                                <?php
                                    break;

                                case 'image':
                                    $field = $config['field'];
                                ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="file" name="<?= $config['field'] ?>" accept="image/*" class="@error($field) is-invalid @enderror">
                                            @error($field)
                                            <?php
                                            switch($field)
                                                {
                                                    case 'productImage':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng chọn hình!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'image':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng chọn hình!' }}</div> 
                                                        <?php
                                                        break;
                                                    }?>
                                            @enderror
                                        </div>
                                    </div>
                                <?php
                                    break;
                                
                                case 'ckediter':
                                    $field = $config['field'];
                                ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <textarea id="<?= $config['field'] ?>" name="<?= $config['field'] ?>" rows="10" cols="80" type="text" class="form-control ckeditor-box" class="@error($field) is-invalid @enderror">
                                            </textarea>
                                            @error($field)
                                            <?php
                                            switch($field)
                                                {
                                                    case 'description':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập mô tả!' }}</div> 
                                                        <?php
                                                        break;
                                                    }?>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                <?php
                                    break;


                                case 'option':
                                    $field = $config['field'];
                                ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">

                                            <select class="select2_single form-control" tabindex="-1" name ="<?= $config['field'] ?>" class="@error($field) is-invalid @enderror">
                                                <option disabled selected='selected'>Vui lòng chọn</option>
                                                
                                                <?php
                                                if (!empty($config['table'])) 
                                                {
                                                    switch ($config['table']) 
                                                    {
                                                        case 'branches': {
                                                                foreach ($getDataBranch as $branch) {
                                                                    $branch = (array)$branch;
                                                ?>                  
                                                                    <option value="<?= $branch['branchID'] ?>"><?= $branch['branchName'] ?></option>
                                                                <?php
                                                                }
                                                            }
                                                            break;
                                                        case 'categories':
                                                            foreach ($getDataCate as $cate) {
                                                                $cate = (array)$cate;
                                                                ?>
                                                                <option value="<?= $cate['categoryID'] ?>"><?= $cate['categoryName'] ?></option>
                                                                
                                                            <?php
                                                            }
                                                            
                                                            break;
                                                        case 'suppliers':
                                                            foreach ($getDataSupp as $supp) {
                                                                $supp = (array)$supp;
                                                            ?>
                                                                <option value="<?= $supp['supplierID'] ?>"><?= $supp['supplierName'] ?></option>
                                                <?php
                                                            }
                                                            break;
                                                        case 'level':
                                                            $lv = 1;
                                                            for($lv; $lv < 8; $lv++) {
                                                            ?>
                                                                <option value="<?= $lv?>"><?= $lv?></option>
                                                <?php
                                                            }
                                                            break;
                                                        case 'birthDay':
                                                            $ns = 1965;
                                                            for($ns; $ns < 2000; $ns++) {
                                                            ?>
                                                                <option value="<?= $ns ?>"><?= $ns ?></option>
                                                <?php
                                                            }
                                                            break;
                                                        case 'gender':
                                                            ?>
                                                                <option value="<?='Nam' ?>"><?= 'Nam' ?></option>
                                                                <option value="<?= 'Nữ' ?>"><?= 'Nữ' ?></option>
                                                <?php
                                                            
                                                            break;
                                                    }
                                                }
                                                ?>
                                            </select>
                                            @error($field)
                                            <?php
                                            switch($field)
                                                {
                                                    case 'categoryID':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng chọn danh mục!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'supplierID':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng chọn nhà cung cấp!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'branchID':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng chọn trung tâm làm việc!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'level':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng chọn  level!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'birthDay':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng chọn  năm sinh!' }}</div> 
                                                        <?php
                                                        break;
                                                    case 'gender':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng chọn giới tính!' }}</div> 
                                                        <?php
                                                        break;
                                                    }?>
                                                    
                                            @enderror
                                        </div>
                                    </div>
                    <?php
                                    break;
                            }
                        }
                    }
                    ?>
                    <div class="ln_solid">
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button name='submit_add'  type='submit' class="btn btn-secondary">Xác Nhận</button>
                                <button class="btn btn-secondary"><a href="{{route('listing.index',['model'=>$modelName])}}" style="color: white">Trở Về</a></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
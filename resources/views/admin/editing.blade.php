@extends('layouts.admin')
@section('content')
<?php 
    $data = (array)$data;
?>
<div class="">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
             
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form class="form-horizontal form-label-left" method="post" action="{{route('editing.postEdit',['model'=>$modelName, 'id' => $id])}}" enctype="multipart/form-data">
                @csrf  <!-- token -->
                    <?php
                    if (!empty($configs) || $change) {
                        foreach ($configs as $config) {
                            switch ($config['type']) {
                                case 'password':
                                case 'text':
                                    if(!empty($config['ID'])){
                    ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="<?= $config['field'] ?>" value='<?=$change ? $id:  $ID?>' readonly class="form-control">
                                        </div>
                                    </div>
                                <?php
                                    break;}
                                else {
                                    ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="<?= $config['field'] ?>" value="<?=$change ? $data[$config['field']]:'' ?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>">
                                        </div>
                                    </div>
                                <?php
                                    break;
                            
                                }
                                case 'number':
                                ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="<?= $config['field'] ?>" value="<?=$change ? $data[$config['field']]:'' ?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>" >
                                        </div>
                                    </div>
                                <?php
                                    break;

                                case 'image':
                                    ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "></label>
                                        <div class="col-md-9 col-sm-9 ">
                                        <img width="15%" onerror="this.src ='/admin_images/no_image.jpg'" 
                                                    src="/admin_images/product/<?= $data[$config['field']]?>" alt="Ảnh đang cập nhật">
                                                    </div>
                                    </div>
                                  <?php 
                                ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="file" name="<?= $config['field'] ?>" accept="image/*">
                                        </div>
                                    </div>
                                <?php
                                    break;

                                case 'ckediter':

                                ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <textarea id="<?= $config['field'] ?>"  name="<?= $config['field'] ?>" rows="10" cols="80" type="text" class="form-control ckeditor-box"><?=$change ? $data[$config['field']]:'' ?></textarea>
                                        </div>
                                    </div>
                                <?php
                                    break;

                                case 'option': {

                                ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">

                                            <select class="select2_single form-control" tabindex="-1" name ="<?= $config['field'] ?>">
                                                <option disabled selected='selected'>Vui lòng chọn</option>
                                                <?php
                                                if (!empty($config['table'])) {
                                                    switch ($config['table']) {
                                                        case 'branches': {
                                                                foreach ($getDataBranch as $branch) {
                                                                    $branch = (array)$branch;
                                                ?>                  
                                                                    <option <?= $data[$config['field']] == $branch['branchID'] ?  'selected':'' ?> value="<?= $branch['branchID'] ?>"><?= $branch['branchName'] ?></option>
                                                                <?php
                                                                }
                                                            }
                                                            break;
                                                        case 'categories':
                                                            foreach ($getDataCate as $cate) {
                                                                $cate = (array)$cate;
                                                                ?>
                                                                <option <?= $data[$config['field']] == $cate['categoryID'] ?  'selected':'' ?>  value="<?= $cate['categoryID'] ?>"><?= $cate['categoryName'] ?></option>
                                                            <?php
                                                            }
                                                            break;
                                                        case 'suppliers':
                                                            foreach ($getDataSupp as $supp) {
                                                                $supp = (array)$supp;
                                                            ?>
                                                                <option <?= $data[$config['field']] == $supp['supplierID'] ?  'selected':'' ?> value="<?= $supp['supplierID'] ?>"><?= $supp['supplierName'] ?></option>
                                                <?php
                                                            }
                                                            break;
                                                        case 'level':
                                                            $lv = 1;
                                                            for($lv; $lv < 8; $lv++) {
                                                            ?>
                                                                <option <?= isset($data[$config['field']]) ?  'selected':'' ?>  value="<?= $lv?>"><?= $lv?></option>
                                                <?php
                                                            }
                                                            break;
                                                            case 'birthDay':
                                                                $ns = 1965;
                                                                for($ns; $ns < 2000; $ns++) {
                                                                ?>
                                                                    <option <?= isset($data[$config['field']]) ?  'selected':'' ?> value="<?= $ns ?>"><?= $ns ?></option>
                                                    <?php
                                                                }
                                                                break;
                                                            case 'gender':
                                                                ?>
                                                                    <option <?= isset($data[$config['field']]) ?  'selected':'' ?> value="<?='Nam' ?>"><?= 'Nam' ?></option>
                                                                    <option <?= isset($data[$config['field']]) ?  'selected':'' ?> value="<?= 'Nữ' ?>"><?= 'Nữ' ?></option>
                                                    <?php
                                                                
                                                                break;
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                    <?php
                                    break;}
                            }
                        }
                    }
                    ?>
                    <div class="ln_solid">
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button name='submit'  type='submit' class="btn btn-secondary">Xác Nhận</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
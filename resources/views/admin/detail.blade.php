@extends('layouts.admin')
@section('content')
<?php 
    $data = (array)$data;
?>
<div class="">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>MM <small>Mega Market</small></h2>
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
                                case 'text':
                                    if(!empty($config['ID'])){
                    ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="<?= $config['field'] ?>" value='<?=$change ? $id:  $ID?>' readonly class="form-control" ?>
                                        </div>
                                    </div>
                                <?php
                                    break;}
                                else {
                                    ?>
                                     
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="<?= $config['field'] ?>" readonly value="<?=$change ? $data[$config['field']]:'' ?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>">
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
                                            <input type="text" name="<?= $config['field'] ?>" readonly value="<?=$change ? $data[$config['field']]:'' ?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>">
                                        </div>
                                    </div>
                                <?php
                                    break;

                                case 'image':
                                    ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                        <img width="15%" onerror="this.src ='/admin_images/no_image.jpg'" 
                                                    src="/admin_images/product/<?= $data[$config['field']]?>" alt="Ảnh đang cập nhật">
                                                    </div>
                                    </div>
                                <?php
                                    break;

                                case 'ckediter':

                                ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <textarea readonly  name="<?= $config['field'] ?>" rows="10" cols="80" type="text" class="form-control ckeditor-box"><?=$change ? $data[$config['field']]:'' ?></textarea>
                                        </div>
                                    </div>
                                <?php
                                    break;

                                case 'option': {

                                ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">

                                           <?php
                                                if (!empty($config['table'])) {
                                                    switch ($config['table']) {
                                                        case 'categories':
                                                            foreach ($getDataCate as $cate) {
                                                                $cate = (array)$cate;
                                                                if($data[$config['field']] == $cate['categoryID']){
                                                                ?>
                                                                <input type="text" name="<?= $config['field'] ?>" readonly value="<?=$cate['categoryName']?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>">
                                                            <?php
                                                            }}
                                                            break;
                                                        case 'birthDay':
                                                                ?>
                                                                <input type="text" name="<?= $config['field'] ?>" readonly value="<?=$data[$config['field']]?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>">
                                                            <?php
                                                            break;
                                                        case 'gender':
                                                            ?>
                                                            <input type="text" name="<?= $config['field'] ?>" readonly value="<?=$data[$config['field']]?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>">
                                                        <?php
                                                        break;
                                                        case 'level':
                                                            ?>
                                                            <input type="text" name="<?= $config['field'] ?>" readonly value="<?=$data[$config['field']]?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>">
                                                        <?php
                                                        break;
                                                        case 'suppliers':
                                                            foreach ($getDataSupp as $supp) {
                                                                $supp = (array)$supp;
                                                                if($data[$config['field']] == $supp['supplierID']){
                                                            ?>
                                                                <input type="text" name="<?= $config['field'] ?>" readonly value="<?=$supp['supplierName']?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>">
                                                                
                                                <?php
                                                            }}
                                                            break;
                                                        case 'branches': {
                                                            foreach ($getDataBranch as $branch) {
                                                                $branch = (array)$branch;
                                                                if($data[$config['field']] == $branch['branchID']){
                                            ?>                  
                                                                <input type="text" name="<?= $config['field'] ?>" readonly value="<?= $branch['branchName'] ?>" class="form-control">
                                                            <?php
                                                            }}
                                                        break;
                                                    }}
                                                }
                                                ?>
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
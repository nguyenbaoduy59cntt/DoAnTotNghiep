@extends('layouts.admin')
@section('content')


<div class="">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>MM <small>Xác nhận đơn hàng</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form class="form-horizontal form-label-left" method="post" action="{{route('orderImport.postConfirm',['model'=>$modelName,'id'=>$id])}}" enctype="multipart/form-data">
                @csrf  <!-- token -->
                    <?php
                    if (!empty($configs)) {
                        foreach ($configs as $config) {
                            switch ($config['type']) {
                                case 'text':
                                    if(!empty($config['ID'])){
                    ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" readonly name="<?= $config['field'] ?>" value='<?=$id?>' class="form-control" ?>
                                        </div>
                                    </div>
                                <?php
                                    break;}
                                else {
                                    ?>
                                     
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" readonly value='<?=!isset($records) ? '': $records[$config['field']]?>' name="<?= $config['field'] ?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>">
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
                                            <input type="text"  name="<?= $config['field'] ?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>">
                                        </div>
                                    </div>
                                <?php
                                    break;

                                case 'image':

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
                                            <textarea id="<?= $config['field'] ?>" name="<?= $config['field'] ?>" rows="10" cols="80" type="text" class="form-control ckeditor-box">
                                            </textarea>
                                        </div>
                                    </div>
                                <?php
                                    break;

                                case 'option':

                                ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">

                                            <select class="select2_single form-control" tabindex="-1" name ="<?= $config['field'] ?>">
                                                <option disabled selected='selected'>Vui lòng chọn</option>
                                                <?php
                                                if (!empty($config['table'])) {
                                                    switch ($config['table']) {
                                                        case 'units': {
                                                                foreach ($getDataUnit as $unit) {
                                                                    $unit = (array)$unit;
                                                                    
                                                ?>                  
                                                                    <option value="<?= $unit['unitID'] ?>"><?= $unit['unitName'] ?></option>
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
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                    <?php
                                    break;
                            }
                        }
                    }
                    ?>
                    

                    <!-- tabletable -->
                    <!-- tabletable -->
                    <!-- tabletable -->
                    <!-- tabletable -->
                    <!-- tabletable -->
                    <div class="clearfix"></div>

    
            <!-- <div class="x_content"> -->
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <?php
                            // var_dump($configs);
                            foreach ($configs2 as $config) {
                            ?>
                                <th><?= $config['name'];?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <!-- tbody -->
                    <!-- tbody -->
                    <!-- tbody -->
                    <!-- tbody -->
                    <!-- tbody -->
                    <!-- tbody -->
                    <tbody>
                        <?php
                        
                        foreach($records2 as $record2){ ?>
                            <tr>
                                <?php
                                foreach ($configs2 as $config) {
                                ?>
                                    <?php
                                    
                                    switch ($config['type']) {
                                        case "text":
                                            if(isset($config['readonly']))
                                            {
                                                ?>
                                                <td><input type="text" readonly value="<?=$record2 -> {$config['field']}?>" name="<?= $config['field'].'[]'?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>"></td>
                                        <?php }
                                        else {
                                            ?>
                                                <td><input type="text" value="<?=$record2 -> {$config['field']}?>" name="<?= $config['field'].'[]'?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>"></td>

                                        <?php }
                                            break;
                                            
                                        
                                        case "number":
                                            if(isset($config['readonly']))
                                            {
                                                ?>
                                                <td><input type="number" readonly value="<?=$record2 -> {$config['field']}?>" name="<?= $config['field'].'[]'?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>"></td>
                                        <?php }
                                        else {
                                            ?>
                                                <td><input type="number" value="<?=$record2 -> {$config['field']}?>" name="<?= $config['field'].'[]'?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>"></td>

                                        <?php }
                                            break;

                                        case "date":
                                                ?>
                                                
                                                <td><input class="date-picker form-control" name="<?= $config['field'].'[]'?>" placeholder="dd-mm-yyyy" type="text" required="required" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)"></td>
												<script>
													function timeFunctionLong(input) {
														setTimeout(function() {
															input.type = 'text';
														}, 60000);
													}
												</script>
                                        <?php 

                                            break;
                                    }
                                    ?>
                                <?php
                                }
                                ?>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                    <!-- tbody -->
                    <!-- tbody -->
                    <!-- tbody -->
                    <!-- tbody -->
                    <!-- tbody -->
                    <!-- tbody -->
                </table>
            <!-- </div> -->
            

                    <!-- table -->
                    <!-- table -->
                    <!-- table -->
                    <!-- table -->
                    <!-- table -->
                    <div class="ln_solid">
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button name='submit_confirm'  type='submit' class="btn btn-secondary">Xác Nhận</button>
                                <button name='submit-trove' type='submit' class="btn btn-secondary"><a href="{{route('admin.import',['model'=>$modelName])}}" style="color: white">Trở Về</a></button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
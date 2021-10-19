@extends('layouts.admin')
@section('content')


<div class="">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>MM <small>Tạo mới</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form class="form-horizontal form-label-left" method="post" action="{{route('orderImport.postCreate',['model'=>$modelName,'n'=>$n + 1])}}" enctype="multipart/form-data">
                @csrf  <!-- token -->
                    <?php
                    if (!empty($configs)) {
                        foreach ($configs as $config) {
                            switch ($config['type']) {
                                case 'text':
                                    $field = $config['field'];
                                    if(!empty($config['ID'])){
                    ?>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="<?= $config['field'] ?>" value='<?=$ID?>' readonly class="form-control" ?>
                                        </div>
                                    </div>
                                <?php
                                    break;}
                                else {
                                    ?>
                                     
                                     
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 "><?= $config['name'] ?></label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text"  value='<?=!isset($records) ? '': $records[$config['field']]?>' name="<?= $config['field'] ?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>"  class="@error($field) is-invalid @enderror">
                                            @error($field)
                                                <?php
                                                switch($field)
                                                {
                                                    case 'employeeID':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập mã nhân viên!' }}</div> 
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
            <ul class="nav navbar-right panel_toolbox">
                    <button type="submit" class="btn btn-secondary" name="addRow">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        
                    </button>
                </ul>
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
                        for ($i = 1; $i <= $n; $i++) { ?>
                            <tr>
                                <?php
                               
                                foreach ($configs2 as $config) {
                                ?>
                                    <?php
                                    // var_dump($records2[$config['field']][$i - 1]);exit;
                                    switch ($config['type']) {
                                        case "text":
                                            $field = $config['field'];
                                            if(!empty($config['ID'])){
                                                ?>
                                            <td>
                                                    <input type="text" require name="<?= $config['field'].'[]' ?>" value='<?=$IDCT[$i - 1]?>' readonly class="form-control" ?>
                                                </td>
                                        <?php
                                            break;}
                                            else{ ?>
                                            <td>
                                                <input type="text" require value="<?=$i == $n ? '': $records2[$config['field']][$i - 1]?>" name="<?= $config['field'].'[]'?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>" class="@error($field) is-invalid @enderror">
                                                @error($field)
                                                    <?php
                                                    switch($field)
                                                    {
                                                        case 'productID':?>
                                                            <div class="alert alert-danger">{{ 'Vui lòng nhập mã sản phẩm!' }}</div> 
                                                            <?php
                                                            break;
                                                    }
                                                    ?>
                                                @enderror
                                            </td>
                                                <?php
                                                break;}
                                            
                                        
                                        case "number": ?>
                                            <td><input type="text" value="<?=$i == $n ?'' : $records2[$config['field']][$i - 1]?>" name="<?= $config['field'].'[]' ?>" class="form-control" placeholder="<?= htmlspecialchars($config['name']) ?>" class="@error($field) is-invalid @enderror">
                                            @error($field)
                                                <?php
                                                switch($field)
                                                {
                                                    case 'quantityPerUnit':?>
                                                        <div class="alert alert-danger">{{ 'Vui lòng nhập số lượng!' }}</div> 
                                                        <?php
                                                        break;
                                                }
                                                ?>
                                            @enderror
                                            </td>
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
                                <button name='submit_add'  type='submit' class="btn btn-secondary">Xác Nhận</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
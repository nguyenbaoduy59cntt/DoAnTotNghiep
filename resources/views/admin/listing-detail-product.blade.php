@extends('layouts.admin')
@section('content')

<!-- top tiles -->
<div class="">
    <div class="page-title">
        <h3 style="text-align: center;"><?= isset($supplierName)? $supplierName :$title ?></h3>
        <?php 
            if(isset($isSup))
            {
            ?>
            <form class="filter-form" method="POST" action="{{route('listing.product',['id'=>$id])}}">
            <?php
            
            }
        else{?>
        <form class="filter-form" method="POST" action="{{route('listing.index',['model'=>$modelName])}}">

            <?php }?>
            @csrf
            <fieldset>
                <legend>Tìm kiếm</legend>
                <?php
                foreach ($configs as $config) {
                    if (!empty($config['filter'])) 
                    {
                        switch ($config['filter']) 
                        {
                            case "equal": ?>
                                <div class="filter-item">
                                    <label><?= $config['name'] ?></label>
                                    <input type="text" name="<?= $config['field'] ?>" value="<?= (!empty($config['filter_value'])) ? $config['filter_value'] : "" ?>">
                                </div>
                            <?php
                                break;

                            case "like": ?>
                                <div class="filter-item">
                                    <label><?= $config['name'] ?></label>
                                    <input type="text" name="<?= $config['field'] ?>" value="<?= (!empty($config['filter_value'])) ? $config['filter_value'] : "" ?>">
                                </div>
                            <?php
                                break;

                            case "between": ?>
                                <div class="filter-item">
                                    <label><?= $config['name'] ?> từ</label>
                                    <input type="text" name="<?= $config['field'] ?>[from]" value="<?= (!empty($config['filter_from_value'])) ? $config['filter_from_value'] : "" ?>">
                                    <label>Đến</label>
                                    <input type="text" name="<?= $config['field'] ?>[to]" value="<?= (!empty($config['filter_to_value'])) ? $config['filter_to_value'] : "" ?>">
                                </div>
                <?php
                                break;
                        }
                    }
                }
                ?>

                <div class="filter-item" id="btnSearch">
                    <button name="submit_search" type="submit" class="btn btn-secondary">
                        <div>Tìm kiếm</div>
                    </button>

                </div>

            </fieldset>
        </form>
    </div>
    <div class="clearfix"></div>

    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>MM Mega Market</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <button type="submit" class="btn btn-secondary">
                        <a style="color:aliceblue" href="{{route('editing.create',['model'=>$modelName])}}">Thêm</a>
                    </button>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <?php
                            // var_dump($configs);
                            foreach ($configs as $config) {
                            ?>
                                <?php if (!empty($config['sort'])) {
                                ?>
                                    <?php
                                    if ($orderBy['field'] == $config['field']) { ?>
                                        <?php
                                        if ($orderBy['sort'] == 'desc') { ?>
                                            <th><?= $config['name'];?><a class="sort-icon" href="{{route('listing.index',['model'=>$modelName,'sort'=>$config['field'].'_asc'])}}"><i class="fa fa-sort-desc" aria-hidden="true"></i></a></th>
                                        <?php
                                        } else {
                                        ?> <th><?= $config['name'] ?><a class="sort-icon" href="{{route('listing.index',['model'=>$modelName,'sort'=>$config['field'].'_desc'])}}"><i class="fa fa-sort-asc" aria-hidden="true"></i></a></th>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    } else { ?>
                                        <th><?= $config['name'] ?><a class="sort-icon" href="{{route('listing.index',['model'=>$modelName,'sort'=>$config['field'].'_desc'])}}"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
                                    <?php
                                    }
                                    ?>
                                <?php
                                } else { ?>
                                    <th><?= $config['name'] ?></th>
                                <?php
                                }
                                ?>

                            <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($records as $record) { ?>
                            <tr>
                                <?php
                               
                                foreach ($configs as $config) {
                                ?>
                                    <?php
                                    switch ($config['type']) {
                                        case "text": ?>
                                            <td><?= $record[$config['field']] ?></td>
                                        <?php
                                            break;

                                        case "option": ?>
                                            <?php
                                            if (!empty($config['forein'])) 
                                            {
                                                $unitName = '';
                                                foreach ($arrayUnits as &$arrayUnit) {

                                                    if ($arrayUnit['unitID'] == $record[$config['field']]) {
                                            ?>
                                                        <td><?= $arrayUnit['unitName'] ?></td>
                                                <?php
                                                        break;
                                                    }
                                                }
                                            } 
                                            else 
                                            {
                                                ?>
                                                <td><?= $record[$config['field']] ?></td>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                            break;

                                        case "image":?>
                                        
                                            <td><img width="20%" onerror="this.src ='/admin_images/no_image.jpg'" 
                                                    src="/admin_images/product/<?= $record[$config['field']]?>" alt="Ảnh đang cập nhật"></td>
                                        <?php
                                            break;

                                        case "number": ?>
                                            <td><?= number_format($record[$config['field']], 0, ',', '.') ?></td>
                                        <?php
                                            break;

                                        case "detail": ?>
                                            <td><a href="{{route('editing.getDetail',['model'=>$modelName,'id'=>$record[$modelID]])}}"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></td>
                                        <?php
                                            break;

                                        case "edit": ?>
                                            <td><a href="{{route('editing.getEdit',['model'=>$modelName,'id'=>$record[$modelID]])}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                        <?php
                                            break;

                                        case "delete": ?>
                                            <td><a onclick="return confirm('Bạn chắc chắn muốn xóa?')" href="{{route('editing.delete',['model'=>$modelName,'id'=>$record[$modelID]])}}">  <i class="fa fa-trash" aria-hidden="true"> </i></a></td>
                                    <?php
                                            break;

                                        case "show-product": ?>
                                        
                                            <td><a href="{{route('listing.product',['id'=>$record[$modelID]])}}"><i class="fa fa-list" aria-hidden="true"></i></a></td>
                                        <?php
                                            break;

                                        case "show-detail": ?>
                                    
                                            <!-- <td><a href="{{route('listingdetail.product',['id'=>$record[$modelID]])}}"><i class="fa fa-list" aria-hidden="true"></i></a></td> -->
                                            <td>
                                            ádffsad
                                                <a href="{{route('listingdetail.product',['id'=>$record[$modelID]])}}"><i class="fa fa-list" aria-hidden="true"></i></a>
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
                </table>
                <?= $records->links("pagination::bootstrap-4") ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
@endsection
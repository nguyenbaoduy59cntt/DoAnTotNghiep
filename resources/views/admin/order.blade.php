@extends('layouts.admin')
@section('content')

<!-- top tiles -->
<div class="">
    <div class="page-title">
        <h3 style="text-align: center;"><?= $title ?></h3>
        
    <div class="clearfix"></div>

    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>MM <small>Mega Market</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <button type="submit" class="btn btn-secondary" name="addRow">
                        <a style="color:aliceblue" href="{{route('orderImport.create',['model'=>$modelName])}}">Thêm</a>
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
                                            <th><?= $config['name'];?><a class="sort-icon" href="{{route('admin.import',['model'=>$modelName,'sort'=>$config['field'].'_asc'])}}"><i class="fa fa-sort-desc" aria-hidden="true"></i></a></th>
                                        <?php
                                        } else {
                                        ?> <th><?= $config['name'] ?><a class="sort-icon" href="{{route('admin.import',['model'=>$modelName,'sort'=>$config['field'].'_desc'])}}"><i class="fa fa-sort-asc" aria-hidden="true"></i></a></th>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    } else { ?>
                                        <th><?= $config['name'] ?><a class="sort-icon" href="{{route('admin.import',['model'=>$modelName,'sort'=>$config['field'].'_desc'])}}"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
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

                                        case "confirm": ?>
                                            <td><?php if($record[$config['field']]) {
                                               echo 'Đã xác nhận';
                                            }else{?>
                                                <a href="{{route('orderImport.getConfirm',['model'=>$modelName,'id'=>$record[$modelID]])}}"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
                                            <?php } ?>  </td>
                                        <?php
                                            break;

                                        case "list": ?>
                                            <td>
                                                <a href="{{route('orderImport.getlist',['model'=>$modelName,'id'=>$record[$modelID]])}}"><i class="fa fa-list" aria-hidden="true"></i></a>
                                            </td>
                                        <?php
                                            break;

                                        case "date": ?>
                                            <td><?= $record[$config['field']] ?></td>
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

                                        case "show": ?>
                                            <td><a href="{{route('listing.product',['id'=>$record[$modelID]])}}"><i class="fa fa-list" aria-hidden="true"></i></a></td>
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
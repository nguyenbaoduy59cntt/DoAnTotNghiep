@extends('layouts.admin')
@section('content')

<!-- top tiles -->
<div class="">
    <div class="page-title">
        <h3 style="text-align: center;"><?= $title ?></h3>
    </div>
    <div class="clearfix"></div>

    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>MM<small>Mega Market</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <button class="btn btn-secondary"><a style="color:aliceblue" target="_blank" href="{{route('admin.prints',['n' => $n])}}">In PDF</a></button>

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <?php
                            foreach ($configs as $config) {
                            // var_dump($config);
                            ?>
                                <th>
                                    <?=
                                    $config['name'];
                                    ?>
                                </th>
                            <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($records as $record) {
                        ?>
                            <tr>
                                <?php
                                foreach ($configs as $config) {
                                ?>
                                    <?php
                                    switch ($config['type']) {
                                        case "text": ?>
                                            <td><?= $record->{$config['field']} ?></td>
                                        <?php
                                            break;

                                        case "number": ?>
                                            <td><?= number_format($record->{$config['field']} , 0, ',', '.') ?></td>
                                        <?php
                                            break;

                                        case "numberquan": ?>
                                            <td style="color: red; font-weight: bold"><?= number_format($record->{$config['field']} , 0, ',', '.') ?></td>
                                    <?php
                                            break;
                                            case "date":
                                                ?>
                                                <td><?= $record->{$config['field']}?></td>
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
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
@endsection
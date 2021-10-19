@extends('layouts.admin')
@section('content')

<!-- top tiles -->
<div class="">
    <div class="page-title">
        <h3 style="text-align: center;">{ { data['title'] } }</h3>
        <button style="border-radius:10px"><a target="_blank" style="font-weight:bold" href="{{route('admin.prints')}}">Xuất File PDF</a></button>
       
    </div>
    <div class="clearfix"></div>

    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Bordered table <small>Bordered table subtitle</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <?php

                            use GuzzleHttp\Psr7\Request;

                            foreach ($configs as $config) {
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
                                            <td><?= $record[$config['field']] ?></td>
                                        <?php
                                            break;

                                        case "number": ?>
                                            <td><?= number_format($record[$config['field']], 0, ',', '.') ?></td>
                                        <?php
                                            break;

                                        case "numberquan": ?>
                                            <td style="color: red; font-weight: bold"><?= number_format($record[$config['field']], 0, ',', '.') ?></td>
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
@extends('layouts.admin')
@section('content')

<div class="row x_title scroll-left">
    <p style="font-size: 22px; color: red; font-weight: bold">MM MEGA MARKET YÊU CẦU CÁC LÃNH ĐẠO TOÀN THỂ VÀ CÔNG NHÂN VIÊN CHUNG TAY PHÒNG CHỐNG COVID-19</p>
</div>

            <div class="container-fluid">
                <div class="col-xl-4 col-md-4 mb-4">
                    <div class="card <?php echo $record0 == 0 ? "border-left-success" : "border-left-danger" ?>   shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold  <?php echo $record0 == 0 ? "text-success" : "text-danger" ?> text-uppercase mb-1">
                                        <h4> <?php echo $record0 == 0 ? "Không có mặt hàng sắp hết" :  "Có $record0 mặt hàng sắp hết" ?></h3>
                                    </div>
                                </div>
                                <div class="col-auto">
                                <a href="{{route('admin.statistics',['n' => '0'])}}"><i style="font-size: 20px;" class="fa fa-chevron-right" aria-hidden="true"></i></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="col-xl-4 col-md-4 mb-4">
                    <div class="card <?php echo $record1 == 0 ? "border-left-success" : "border-left-danger" ?>   shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold  <?php echo $record1 == 0 ? "text-success" : "text-danger" ?> text-uppercase mb-1">
                                        <h4> <?php echo $record1 == 0 ? "Không có mặt hàng tồn kho" :  "Có $record1 mặt hàng tồn kho" ?></h3>
                                    </div>

                                </div>
                                <div class="col-auto">
                                <a href="{{route('admin.statistics',['n' => '1'])}}"><i style="font-size: 20px;" class="fa fa-chevron-right" aria-hidden="true"></i></a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="col-xl-4 col-md-4 mb-4">
                    <div class="card <?php echo $record2 == 0 ? "border-left-success" : "border-left-danger" ?>   shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold  <?php echo $record2 == 0 ? "text-success" : "text-danger" ?> text-uppercase mb-1">
                                        <h4> <?php echo $record2 == 0 ? "Không có mặt hàng hết hạn sử dụng" :  "Có $record2 mặt hàng hết hạn " ?></h3>
                                    </div>

                                </div>
                                <div class="col-auto">
                                <a href="{{route('admin.statistics',['n' => '2'])}}"><i style="font-size: 20px;" class="fa fa-chevron-right" aria-hidden="true"></i></a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('admin.dashboard')}}" class="site_title"><i style="font-size: 20px;" >MM</i> <span>Mega Market</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img style="width: 70px; height: 70px;" src="https://is4-ssl.mzstatic.com/image/thumb/Purple125/v4/28/f4/de/28f4debf-e875-b490-7985-e68b9745784d/source/256x256bb.jpg" alt="k cos" class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Xin chào <?= isset($user) ? '<h2>'.$user->name.'</h2>' : '<h2>'.$employee->lastName.' '.$employee->firstName.'</h2>'?></span>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Quản trị hệ thống</h3>
                <?php 
                $check = 1;
                if($check == 1){ ?>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i>Quản lý sản phẩm<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('listing.index',['model'=>'Supplier'])}}">Nhà cung cấp</a></li>
                            <li><a href="{{route('listing.index',['model'=>'Category'])}}">Danh mục sản phẩm</a></li>
                            <li><a href="{{route('listing.index',['model'=>'Product'])}}">Sản phẩm</a></li>
                        </ul>
                    </li>
                    <?php 
                        if(isset($user))
                        {?>
                            <li><a><i class="fa fa-user"></i>Quản lý nhân viên<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="{{route('listing.index',['model'=>'Employee'])}}">Danh sách nhân viên</a></li>
                                </ul>
                            </li>
                        <?php
                        } 
                        ?>
                
                   
                    <li><a><i class="fa fa-file-text"></i>Quản lý nhập hàng<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('admin.import',['model'=>'ImportOrder'])}}">Đơn hàng nhập</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-file-text"></i>Báo cáo thống kê<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('admin.statistics',['n' => '0'])}}">Mặt hàng cảnh báo</a></li>
                            <li><a href="{{route('admin.statistics',['n' => '1'])}}">Mặt hàng tồn kho</a></li>
                            <li><a href="{{route('admin.statistics',['n' => '2'])}}">Mặt hàng hết hạn</a></li>
                        </ul>
                    </li>
                
                </ul>
                <?php }
                else { ?>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i>Quản lý sản phẩm<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('listing.index',['model'=>'Supplier'])}}">Nhà cung cấp</a></li>
                            <li><a href="{{route('listing.index',['model'=>'Category'])}}">Danh mục sản phẩm</a></li>
                            <li><a href="{{route('listing.index',['model'=>'Product'])}}">Sản phẩm</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-file-text"></i>Quản lý nhập hàng<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('admin.import',['model'=>'ImportOrder'])}}">Đơn hàng nhập</a></li>
                        </ul>
                    </li>
                </ul>
                <?php }?>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{route('admin.logout')}}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
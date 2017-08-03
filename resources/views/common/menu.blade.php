<div class="sidebar-inner slimscrollleft">
    <!--- Divider -->
    <div id="sidebar-menu">
        <ul>

            <li class="text-muted menu-title">Danh mục</li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="ti-home"></i> <span> Dashboard </span> <span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="/">Dashboard 1</a></li>
                    <li><a href="dashboard_2.html">Dashboard 2</a></li>
                    <li><a href="dashboard_3.html">Dashboard 3</a></li>
                    <li><a href="dashboard_4.html">Dashboard 4</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('songs.index') }}" class="waves-effect"><i class="ti-home"></i> <span> Danh mục bài hát </span> <span class="menu-arrow"></span></a>
            </li>

            <li>
                <a href="{{ route('ktvreports.index') }}" class="waves-effect"><i class="ti-home"></i> <span> Báo cáo </span> <span class="menu-arrow"></span></a>
            </li>

            <li>
                <a href="{{ route('singers.index') }}" class="waves-effect"><i class="ti-home"></i> <span> Danh mục ca sĩ </span> <span class="menu-arrow"></span></a>
            </li>

            @role('admin')
                <li>
                    <a href="{{ route('ktvs.index') }}" class="waves-effect"><i class="ti-home"></i> <span> Đơn vị kinh doanh </span> <span class="menu-arrow"></span></a>
                </li>

                <li>
                    <a href="{{ route('contentowners.index') }}" class="waves-effect"><i class="ti-home"></i> <span> Đơn vị sở hữu bản quyền </span> <span class="menu-arrow"></span></a>
                </li>

                <li>
                    <a href="{{ route('configs.index') }}" class="waves-effect"><i class="ti-home"></i> <span> Cấu hình </span> <span class="menu-arrow"></span></a>
                </li>
            @endrole

            <li>
                <a href="{{ route('contentowner-reports.index') }}" class="waves-effect"><i class="ti-home"></i> <span>Thống kê đơn vị sở hữu</span> <span class="menu-arrow"></span></a>
            </li>

        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>

<style>
    #sidebar-menu > ul > li > a {
        padding: 12px 10px;
    }
    #sidebar-menu ul ul a {
        padding: 10px 20px 10px 35px;
    }
</style>
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
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="ti-layout-grid2"></i> <span> Quản lý </span> <span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('songs.index') }}" class="waves-effect"> <span> Danh mục bài hát </span> </a>
                    </li>
                    <li>
                        <a href="{{ route('singers.index') }}" class="waves-effect"> <span> Danh mục ca sĩ </span> </a>
                    </li>
                    @role('admin')
                    <li>
                        <a href="{{ route('ktvs.index') }}" class="waves-effect"> <span> Đơn vị kinh doanh </span> </a>
                    </li>

                    <li>
                        <a href="{{ route('contentowners.index') }}" class="waves-effect"> <span> Đơn vị sở hữu bản quyền </span> </a>
                    </li>
                    @endrole
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="ti-layout-grid2"></i> <span> Thống kê </span> <span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('ktvreports.index') }}" class="waves-effect"> <span> Báo cáo đơn vị kinh doanh </span> </a>
                    </li>
                </ul>
            </li>

            @role('admin')
            <li>
                <a href="{{ route('configs.index') }}" class="waves-effect"><i class="ti-settings"></i> <span> Cấu hình </span> </a>
            </li>
            @endrole
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>

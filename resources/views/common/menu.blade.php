<style>
    #sidebar-menu > ul > li > a {
        padding: 12px 10px;
    }
    #sidebar-menu ul ul a {
        padding: 10px 20px 10px 35px;
    }
</style>

@php
$user = Auth::user();
@endphp
<div class="sidebar-inner slimscrollleft">
    <!--- Divider -->
    <div id="sidebar-menu">
        <ul>

            <li class="text-muted menu-title">Danh mục</li>

            <li>
                <a href="/" class="waves-effect"><i class="ti-home"></i> <span> Dashboard </span> </a>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="ti-layout-grid2"></i> <span> Báo cáo </span> <span class="menu-arrow"></span></a>
                <ul class="list-unstyled" style="display: block;">
                    <li>
                        <a href="{{ route('ktvreports.index') }}" class="waves-effect"> <span> Báo cáo đơn vị kinh doanh </span> </a>
                    </li>
                    <li>
                        <a href="{{ route('ktvreports.fee') }}" class="waves-effect"> <span> Thu chi đơn vị kinh doanh </span> </a>
                    </li>
                    <li>
                        <a href="{{ route('contentowner-reports.index') }}" class="waves-effect"> <span>Báo cáo đơn vị sở hữu</span> </a>
                    </li>
                    <li>
                        <a href="{{ route('song-reports.index') }}" class="waves-effect"> <span>Báo cáo sử dụng bài hát</span> </a>
                    </li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="ti-layout-grid2"></i> <span> Danh mục </span> <span class="menu-arrow"></span></a>
                <ul class="list-unstyled" style="display: block;">
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
            <li>

            @if ($user->can('configs.index'))
            <li>
                <a href="{{ route('configs.index') }}" class="waves-effect"><i class="ti-settings"></i> <span> Cấu hình </span> </a>
            </li>
            @endif







        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
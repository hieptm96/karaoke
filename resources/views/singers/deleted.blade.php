@extends('layouts.app')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            <h4 class="page-title">Bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li>
                    <a href="{{ route('singers.index') }}">Ca sĩ</a>
                </li>
                <li class="active">
                    Thông tin ca sĩ
                </li>
            </ol>
        </div>
    </div>

    <a href="{{ route('singers.index') }}">
        <div class="alert alert-success fade in alert-dismissable">
            <strong>Đã xóa thành công ca sĩ!</strong>
            <br />
            <strong>Bấm để xem danh sách ca sĩ</strong>
        </div>
    </a>

@endsection

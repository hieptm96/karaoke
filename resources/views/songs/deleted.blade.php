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
                    <a href="{{ route('songs.index') }}">Bài hát</a>
                </li>
                <li class="active">
                    Thông tin bài hát
                </li>
            </ol>
        </div>
    </div>

    <a href="{{ route('songs.index') }}">
        <div class="alert alert-success fade in alert-dismissable">
            <strong>Đã xóa thành công bài hát!</strong>
            <br />
            <strong>Bấm để xem danh sách bài hát</strong>
        </div>
    </a>

@endsection

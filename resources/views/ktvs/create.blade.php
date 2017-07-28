@extends('layouts.app')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('ktvs.index') }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
            </div>

            <h4 class="page-title">Bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li class="active">
                    Thêm mới
                </li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title"><b>Thêm mới đơn vị kinh doanh</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <form action="{{ route('ktvs.store')  }}" method="POST" class="form-horizontal" role="form" data-parsley-validate="" novalidate="">
                    @include('ktvs._form')
                </form>
            </div>
        </div>
    </div>

@endsection
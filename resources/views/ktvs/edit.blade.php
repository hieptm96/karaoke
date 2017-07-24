@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
@endpush

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
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

                <form action="{{ route('ktvs.update', ['id' => $ktv->id])  }}" method="POST" class="form-horizontal" role="form" data-parsley-validate="" novalidate="">
                    {{ method_field('patch') }}
                    @include('ktvs._form')
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="/vendor/ubold/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>

@endpush

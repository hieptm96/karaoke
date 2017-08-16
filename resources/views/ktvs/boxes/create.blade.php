@extends('layouts.app')

@section('content')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ url()->previous() }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
            </div>

            <h4 class="page-title">Danh mục đơn vị kinh doanh</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('ktvs.index') }}">Đơn vị kinh doanh</a>
                </li>
                <li>
                    {{ $ktv->name }}
                </li>
                <li class="active">
                    Thêm mới đầu máy/thiết bị phát
                </li>
            </ol>
        </div>
    </div>

    @include('flash-message::default')

    @include('common.request_errors')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title"><b>Thông tin đầu máy/thiêt bị phát</b></h4>
                <p class="text-muted font-13 m-b-30">
                </p>

                <form class="form-horizontal" method="post" id="edit-box-form" role="form"  data-parsley-validate
                      action="{{ route('ktvs.boxes.store', ['ktv' => $ktv->id]) }}">
                    {{ csrf_field() }}

                    @include('ktvs.boxes._form')

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                Thêm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>
@endpush

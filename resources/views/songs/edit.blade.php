@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/custom.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')

    @include('songs.singer-modal')

    @include('songs.content-owner-modal')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            <div class="btn-group pull-right m-t-15">
                <a href="{{ url()->previous() }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
            </div>

            <h4 class="page-title">Bài hát</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li>
                    <a href="{{ route('songs.index') }}">Bài hát</a>
                </li>
                <li class="active">
                    Sửa Thông tin bài hát
                </li>
            </ol>
        </div>
    </div>

    @include('flash-message::default')

    @include('common.request_errors')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Thông tin bài hát</b></h4>

                <form class="form-horizontal" id="song-filer-form" method="post" action="{{ route('songs.update', $song['id'])}}" role="form"  data-parsley-validate>
                   <input name="_method" value="PUT" type="hidden">
                   <input type="hidden" value="{{ csrf_token() }}" name="_token">
                   <input type="hidden" value="{{ $song['id'] }}" name="song_id">

                    @include('songs._form')

                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                      <button type="submit" class="btn btn-primary waves-effect waves-light">
                        Cập nhật
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
<script src="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.js"></script>


<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/main.js"></script>
<script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>

@endpush

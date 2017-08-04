@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
@endpush

@section('content')

    @include('songs.singer-modal')

    @include('songs.owner-modal')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            @if ( session('created') )
                <div class="btn-group pull-right m-t-15">
                    <a href="{{ route('songs.create') }}" class="btn btn-default"><i class="md md-add"></i> Thêm tiếp </a>
                </div>
            @else
                <div class="btn-group pull-right m-t-15">
                    <a href="{{ route('songs.index') }}"><button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light">Quay lại </button></a>
                </div>
            @endif


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

    @include('flash-message::default')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Thông tin bài hát</b></h4>

                <form class="form-horizontal" id="song-filer-form" method="post" action="/songs/{{ $song['id'] }}" role="form"  data-parsley-validate novalidate>
                   <input name="_method" value="PUT" type="hidden">
                   <input type="hidden" value="{{ csrf_token() }}" name="_token">

                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên: </label>
                    <div class="col-sm-7">
                      <input type="text" readonly name="name" value="{{ $song['name'] }}" class="form-control" id="input-name" placeholder="Tên" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="singers" class="col-sm-4 control-label">Ca sĩ: </label>
                    <div class="col-sm-7">
                      @foreach ($song['singers'] as $singer)
                      <div class="singer">
                          <div class="input-group span6 offset3">
                              <input type="text" readonly class="form-control" value="{!! $singer->name !!}"/>
                          </div>
                          <br/>
                      </div>
                      @endforeach
                    </div>
                    @if (count($song['singers']) == 0)
                          <div class="col-sm-7">
                            <input type="text" readonly name="name" value="Không có ca sĩ nào hát bài này!!!" class="form-control">
                          </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="language-picker" class="col-sm-4 control-label">Ngôn ngữ: </label>
                    <div class="col-sm-7">
                      <input type="text" readonly value="{{ config('ktv.languages.'.$song['language'], '') }}" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
					<label class="col-sm-4 control-label">Tình trạng:</label>
					<div class="col-sm-6">
                        <div>
                        @if ($song['has_fee'])
                            <span class="label label-success">Có phí</span>
                        @else
                            <span class="label label-primary">Không phí</span>
                        @endif
                        </div>
					</div>
				</div>

                  <hr />

                  <div class="form-group">
                    <label for="singers" class="col-sm-4 control-label">Đơn vị sở hữu nội dung: </label>

                    <div class="col-sm-6">
                        <br />

                        <div class="">
                          <label for="singers" class="">Nhạc sĩ: </label>
                          <div class="">
                            <input type="text" readonly class="form-control"  value="{{ $song['contentOwners']['musican']['name'] or '' }}">
                          </div>
                        </div>

                        <div class="">
                          <label for="singers" class="">Lời: </label>
                          <div class="">
                                <input type="text" readonly class="form-control"  value="{{ $song['contentOwners']['title']['name'] or '' }}">
                          </div>
                        </div>

                        <div class="">
                          <label for="singers" class="">Ca sĩ: </label>
                          <div class="">
                                <input type="text" readonly class="form-control"  value="{{ $song['contentOwners']['singer']['name'] or '' }}">
                          </div>
                        </div>


                        <div class="">
                          <label for="singers" class="">Quay phim: </label>
                          <div class="">
                                <input type="text" readonly class="form-control"  value="{{ $song['contentOwners']['film']['name'] or '' }}">
                          </div>
                        </div>
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="created-by"class="col-sm-4 control-label">Người tạo: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $song['created_by'] }}" id="created_by" placeholder="Người tạo" class="form-control" readonly required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="webSite" class="col-sm-4 control-label">Thời gian tạo: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $song['created_at'] }}" id="created-at" required  class="form-control" readonly placeholder="Ngày tạo">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="webSite" class="col-sm-4 control-label">Thời gian sửa đổi lần cuối: </label>
                    <div class="col-sm-7">
                      <input type="text" value="{{ $song['updated_at'] }}" id="webSite" required class="form-control" readonly placeholder="Ngày sửa đổi cuối">
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
<script src="/vendor/ubold/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/vendor/ubold/assets/plugins/parsleyjs/parsley.min.js"></script>

@endpush

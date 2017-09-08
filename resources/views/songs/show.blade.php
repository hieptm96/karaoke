@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')

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

                <form class="form-horizontal" id="song-filer-form" role="form"  data-parsley-validate novalidate>

                  <div class="form-group">
                    <label for="input-name" class="col-sm-4 control-label">Tên: </label>
                    <div class="col-sm-7">
                      <span class="form-control">{{ $song['name'] }}</span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="singers" class="col-sm-4 control-label">Ca sĩ: </label>
                    <div class="col-sm-7">
                      @foreach ($song['singers'] as $singer)
                      <div class="singer">

                        <span class="form-control" singer-data="{{ $singer->id }}">{!! $singer->name !!}</span>

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
                        <span class="form-control">{{ config('ktv.languages.'.$song['language'], '') }}</span>
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

                    <div class="col-sm-7">
                        <br />

                        <table id="author" class="table table-striped table-bordered">
                            <tr>
                                <th width="10%">Mã</th>
                                <th>Quyền tác giả</th>
                            </tr>

                            @if (!empty($song['contentOwners']['author']))
                                @foreach ($song['contentOwners']['author'] as $owner)
                                    <tr class="content-owner">
                                        <td class="id"><input size="10" class="input-td" type="text" readonly value="{{ $owner['id'] }}"></td>
                                        <td class="name">{{ $owner['name'] }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td valign="top" colspan="10">Hiện chưa có</td>
                                </tr>
                            @endif
                        </table>

                        <div class="">
                            <label for="" class=""></label>
                            <div class="">
                                <table id="record" class="table table-striped table-bordered dataTable">
                                    <tr>
                                        <th width="10%">Mã</th>
                                        <th>Quyền bản ghi</th>
                                    </tr>

                                    @if (!empty($song['contentOwners']['record']))
                                        @foreach ($song['contentOwners']['record'] as $owner)
                                            <tr class="content-owner">
                                                <td class="id"><input size="10" class="input-td" type="text" readonly value="{{ $owner['id'] }}"></td>
                                                <td class="name">{{ $owner['name'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td valign="top" colspan="10">Hiện chưa có</td>
                                        </tr>
                                    @endif

                                </table>
                            </div>
                        </div>

                    </div>
                  </div>

                </form>
              </div>
            </div>
        </div>
    </div>

@endsection

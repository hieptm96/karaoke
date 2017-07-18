@extends('layouts.singers-management')

@section('content')

  {{-- add singer modal --}}
  <div id="add-singer-modal" class="modal-demo">
      <button type="button" class="close" onclick="Custombox.close();">
          <span>&times;</span><span class="sr-only">Close</span>
      </button>
      <h4 class="custom-modal-title">Thêm ca sĩ</h4>
      <div class="custom-modal-text text-left">
          <form role="form">
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" placeholder="Nhập tên ca sĩ" required>
              </div>

              <div class="form-group">
                  <label for="name">Giới tính</label>
                  <br />
                  <label class="radio-inline"><input type="radio" class="sex" name="sex" value="1" require>Nam</label>
                  <label class="radio-inline"><input type="radio" class="sex" name="sex" value="2" require>Nữ</label>
                  <label class="radio-inline"><input type="radio" class="sex" name="sex" value="3" require>Giới tính khác</label>
              </div>

              <div class="text-right">
                  <button type="submit" class="btn btn-danger waves-effect waves-light">Save</button>
                  <button type="button" class="btn btn-default waves-effect waves-light" onclick="Custombox.close();">Cancel</button>
              </div>
          </form>
      </div>
  </div>


{{-- delete singer modal --}}
<div id="delete-singer-modal" class="modal-demo" data="">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Delete singer</h4>
    <div class="custom-modal-text text-left">
        <form role="form" id="delete-singer-form" method="post" action="/singers/delete">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" id="singerID" name="singerID" value="">
            <div class="text-right">
                <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                <button type="button" class="btn btn-default waves-effect waves-light m-l-10" onclick="Custombox.close();">Cancel</button>
            </div>
        </form>
    </div>
</div>


{{-- edit singer modal --}}
<div id="edit-singer-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Edit singer</h4>
    <div class="custom-modal-text text-left">
        <form role="form" id="edit-singer-form" action="/singers/edit"  method="post" data="">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" id="singerID" name="singerID" value="">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required>
            </div>

            <div class="form-group">
                <label for="name">Giới tính</label>
                <br />
                <label class="radio-inline"><input type="radio" class="sex" name="sex" value="1" require>Nam</label>
                <label class="radio-inline"><input type="radio" class="sex" name="sex" value="2" require>Nữ</label>
                <label class="radio-inline"><input type="radio" class="sex" name="sex" value="3" require>Giới tính khác</label>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-danger waves-effect waves-light">Save</button>
                <button type="button" class="btn btn-default waves-effect waves-light" onclick="Custombox.close();">Cancel</button>
            </div>
        </form>
    </div>
</div>


<div class="container">

  <!-- Page-Title -->
  <div class="row">
    <div class="col-sm-12">
      <h4 class="page-title">Customers</h4>
      <ol class="breadcrumb">
        <li><a href="#">Ubold</a></li>
        <li><a href="#">Apps</a></li>
        <li class="active">Customers</li>
      </ol>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card-box">
        <div class="row">
          <div class="col-sm-8">
            <form role="form" method="get" action="/singers/search/">
              <div class="form-group contact-search m-b-30">
                <input type="text" id="search" name="q" class="form-control"
                value="{{ $query or "" }}" placeholder="Nhập tên ca sĩ...">
                <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
              </div> <!-- form-group -->
            </form>
          </div>
          <div class="col-sm-4">
            <a href="#add-singer-modal" class="btn btn-default btn-md waves-effect waves-light m-b-30" data-animation="fadein"
            data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Thêm ca sĩ</a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover mails m-0 table table-actions-bar">
            <thead>
              <tr>
                <th>
                  <div class="checkbox checkbox-primary checkbox-single m-r-15">
                    <input id="action-checkbox" type="checkbox">
                    <label for="action-checkbox"></label>
                  </div>
                  {{-- <div class="btn-group dropdown">
                    <button type="button" class="btn btn-white btn-xs dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Action</a></li>
                      <li><a href="#">Another action</a></li>
                      <li><a href="#">Something else here</a></li>
                      <li class="divider"></li>
                      <li><a href="#">Separated link</a></li>
                    </ul>
                  </div> --}}
                </th>
                <th>Tên</th>
                <th>Giới tính</th>
                <th>Người sửa đổi cuối</th>
                <th></th>
              </tr>
            </thead>

            <tbody>

              @foreach ($singers as $singer)
              <tr data='{{ $singer->id }}' class="singer">
                <td>
                  <div class="checkbox checkbox-primary m-r-15">
                    <input type="checkbox">
                    <label for="checkbox2"></label>
                  </div>

                  <img src="/vendor/ubold/assets/images/users/avatar-2.jpg" alt="contact-img" title="contact-img" class="img-circle thumb-sm" />
                </td>

                <td class="name" id="name">
                  {{ $singer->name }}
                </td>


                  @if ($singer->sex === 1)
                    <td id="sex" data="1">
                      Nam
                    </td>
                  @elseif ($singer->sex == 2)
                    <td id="sex" data="2">
                      Nữ
                    </td>
                  @else
                    <td id="sex" data="3">
                      Giới tính khác
                    </td>
                  @endif


                <td class="created-by">
                  {{ $singer->createdBy->name }}
                </td>

                <td>
                  <a href="#edit-singer-modal" class="table-action-btn" data-animation="fadein" data-plugin="custommodal"
                  data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-edit"></i></a>
                  <a href="#delete-singer-modal" class="table-action-btn" data-animation="fadein" data-plugin="custommodal"
                  data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-close"></i></a>
                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
      </div>

    </div> <!-- end col -->


  </div>



</div> <!-- container -->

</div> <!-- content -->
@endsection

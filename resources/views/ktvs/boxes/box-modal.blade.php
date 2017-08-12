<!-- Edit box modal -->
<div class="modal fade" id="edit-box-modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Chỉnh sửa thông tin đầu máy/thiết bị phát
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form class="form-horizontal" id="edit-box-form" >
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <div class="form-group">
                        <label  class="col-sm-2 control-label"
                                for="code">Mã đầu máy*</label>
                        <div class="col-sm-10">
                            <input type="code" class="form-control"
                                   id="code" placeholder="Mã đầu máy"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="info" >Thông tin</label>
                        <div class="col-sm-10">
                            <textarea class="form-control"
                                      id="info" placeholder="Thông tin đầu máy"></textarea>
                        </div>
                    </div>
                </form>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" id="done" class="btn btn-default"
                        data-dismiss="modal">
                    Xong
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Hủy
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add box modal -->
<div class="modal fade" id="add-box-modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Thêm mới đầu máy/thiết bị phát
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form class="form-horizontal" id="add-box-form" 
                    action="{{ route('ktvs.boxes.store', ['ktv' => 1])  }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label  class="col-sm-2 control-label"
                                for="code">Mã đầu máy</label>
                        <div class="col-sm-10">
                            <input type="code" class="form-control"
                                   id="code" placeholder="Mã đầu máy"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="info" >Thông tin</label>
                        <div class="col-sm-10">
                            <textarea class="form-control"
                                      id="info" placeholder="Thông tin đầu máy"></textarea>
                        </div>
                    </div>
                </form>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-default"
                        data-dismiss="modal">
                    Xong
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Hủy
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Delete box modal --}}
<div id="delete-song-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Xóa bài hát</h3>
        </div>
        <div class="modal-body">
            <p>Bạn có chắc muốn xóa bài hát không?</p>
        </div>
        <div class="modal-footer">
          <div class="custom-modal-text text-left">
              <form role="form" id="delete-form" method="post" action="">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                  <div class="text-right">
                      <button type="submit" class="btn btn-primary waves-effect waves-light">Xóa</button>
                      <button type="button" class="btn btn-default waves-effect waves-light m-l-10" data-dismiss="modal">Hủy</button>
                  </div>
              </form>
          </div>
        </div>
    </div>

  </div>
</div>
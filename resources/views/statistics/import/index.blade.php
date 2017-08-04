@extends('layouts.app')

@push('styles')
    <link href="/vendor/ubold/assets/plugins/ladda-buttons/css/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">

            <h4 class="page-title">Thống kê dữ liệu</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="#">KTV</a>
                </li>
                <li class="active">
                    Import dữ liệu sử dụng
                </li>
            </ol>
        </div>
    </div>

    <div class="" id="alert-section">
    </div>

    <div class="row">
		<div class="col-sm-12">
			<div class="card-box">
				<h4 class="m-t-0 header-title"><b>Chọn file dữ liệu</b></h4>
				<div class="row">
					<div class="col-md-6">
						<div class="p-20">
							<form method="post"  enctype="multipart/form-data" id="upload-form">
                                {{ csrf_field()  }}
                                <div class="form-group">
                                    <label class="control-label">Chọn file dữ liệu(.xls, .xlsx)</label>
                                    <input type="file"id="file-chooser" name="data-usage" class="filestyle" required data-buttonbefore="true" accept=".xls,.xlsx">
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="upload-file-btn" class="ladda-button btn btn-primary" data-style="expand-left">
                                        Upload file
                                    </button>
                                </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@push('scripts')
<script src="/vendor/ubold/assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
<script src="/vendor/ubold/assets/plugins/ladda-buttons/js/spin.min.js"></script>
<script src="/vendor/ubold/assets/plugins/ladda-buttons/js/ladda.min.js"></script>
<script src="/vendor/ubold/assets/plugins/ladda-buttons/js/ladda.jquery.min.js"></script>

@endpush

@push('inline_scripts')
<script src="http://malsup.github.com/jquery.form.js"></script>

<script>
    var uploadButton;

    $(document).ready(function() {

        var uploadFileBtn = $('#upload-file-btn').ladda();

        var options = {
            dataType: "json",
            beforeSubmit: function() {
                uploadFileBtn.ladda('start');
                $('#alert-section').html('');
            },
            success: function(responseText) {
                var alert = createAlert(responseText);
                $('#alert-section').html(alert);
            },
            complete: function() {
                uploadFileBtn.ladda('stop');
            }
        };

        $('#upload-form').ajaxForm(options);

    });

    function createAlert(data) {
        var alert = '<div class="alert alert-' + data['alert-type'] + ' alert-dismissable">'
        +      '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
        +      '<strong>' + data['message'] + '</strong>'
        +    '</div>';

        return alert;
    }

    $(document).on('click', '.format-file', function(e) {
        e.preventDefault();
        location.href = $(this).attr('href');
    });

    $(document).on('change', '#file-chooser', function(e) {
        $('#alert-section').html('');
    });


</script>


@endpush

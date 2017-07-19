<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<div ng-app="ktv-form" ng-controller="ktv-ctl">
    {{ csrf_field()  }}

    <div class="form-group">
        <label for="name" class="col-sm-4 control-label pull-left">Tên*</label>
        <div class="col-sm-7">
            <input type="text" required="" parsley-type="text" name="name" class="form-control" id="name" placeholder="Tên" value="{{ isset($ktv) ? old('name', $ktv->name) : old('name') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="representative" class="col-sm-4 control-label pull-left">Người đại diện*</label>
        <div class="col-sm-7">
            <input type="text" required="" parsley-type="text" name="representative" class="form-control" id="representative" placeholder="Người đại diện" value="{{ isset($ktv) ? old('representative', $ktv->representative) : old('representative') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="phone" class="col-sm-4 control-label pull-left">Số điện thoại*</label>
        <div class="col-sm-7">
            <input type="text" required="" parsley-type="text" name="phone" class="form-control" id="phone" placeholder="Số điện thoại" value="{{ isset($ktv) ? old('phone', $ktv->phone) : old('phone') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-4 control-label pull-left">Email*</label>
        <div class="col-sm-7">
            <input type="email" required="" parsley-type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ isset($ktv) ? old('email', $ktv->user->email) : old('email') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-sm-4 control-label pull-left">Địa chỉ liên lạc*</label>
        <div class="col-sm-7">
            <input type="text" required="" parsley-type="address" name="address" class="form-control" id="address" placeholder="Địa chỉ liên lạc" value="{{ isset($ktv) ? old('address', $ktv->address) : old('address') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="province" class="col-sm-4 control-label pull-left">Tỉnh*</label>
        <div class="col-sm-7">
            <select name="province" id="province" class="form-control" ng-model="province" ng-change="get_districts()">
                <option value="">-- Chọn tỉnh --</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" selected="{{ (isset($ktv) && (old('province',$ktv->province_id) == $province->id)) | (old('province') == $province->id) ? "selected" : "" }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{$ktv->province_id}}
    <div class="form-group">
        <label for="district" class="col-sm-4 control-label pull-left">Quận/Huyện*</label>
        <div class="col-sm-7">
            <select name="district" id="district" class="form-control">
                <option ng-if="districts.length ==0" value="">-- Chọn Quận/Huyện --</option>
                <option ng-repeat="district in districts" value="<% district.id %>"><% district.name %></option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="hori-pass1" class="col-sm-4 control-label">Password*</label>
        <div class="col-sm-7">
            <input type="password" name="password" id="password" placeholder="Password" required="" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <button type="submit" class="btn btn-primary waves-effect waves-light">
                Tạo
            </button>
            <button type="reset" class="btn btn-default waves-effect waves-light m-l-5">
                Hủy
            </button>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="/js/main.js"></script>

@endpush
<script>
    var url = '{{ route('ktvs.getdistricts') }}';
</script>
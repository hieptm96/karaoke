<div class="form-group">
    <label  class="col-sm-4 control-label" for="code">Mã đầu máy*</label>
    <div class="col-sm-7">
        <input type="code" id="code" class="form-control" name="code" placeholder="Mã đầu máy" required
               value="{{ isset($box) ? old('code', $box->code) : old('code')}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label" for="info" >Thông tin</label>
    <div class="col-sm-7">
        <textarea class="form-control" id="info" name="info" placeholder="Thông tin đầu máy">{{ isset($box) ? old('info', $box->info) : old('info') }}</textarea>
    </div>
</div>

<div class="form-group row">
    <label for="permissions_name_jp" class="form-label col-3 col-sm-3 col-md-2">@lang('general.common.name_jp')
        <span class="text-danger">*</span></label>
    <div class="col-9 col-sm-9 col-md-10">
        <input type="text" class="form-control @error('permissions_name_jp') is-invalid @enderror"
            id="permissions_name_jp" name="permissions_name_jp" placeholder="@lang('general.common.name_jp')"
            value="{{ Request::old('permissions_name_jp', $dataObj->name_jp ?? '') }}" maxlength="255">
        @error('permissions_name_jp')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="permissions_name" class="form-label col-3 col-sm-3 col-md-2">@lang('general.common.name')
        <span class="text-danger">*</span></label>
    <div class="col-9 col-sm-9 col-md-10">
        <input type="text" class="form-control @error('permissions_name') is-invalid @enderror" id="permissions_name"
            name="permissions_name" placeholder="@lang('general.common.name')"
            value="{{ Request::old('permissions_name', $dataObj->name ?? '') }}" maxlength="255">
        @error('permissions_name')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="permissions_resource_id" class="form-label col-3 col-sm-3 col-md-2"
        aria-required="true">@lang('permissionsLng.permissions_resource_id')</label>
    <div class="col-9 col-sm-9 col-md-10">
        <select class="js-example-basic-single form-control @error('permissions_resource_id') is-invalid @enderror"
            id="permissions_resource_id" name="permissions_resource_id">
            @if (count($dataObjResource))
                <option value="" selected disabled>@lang('Select a Resource')</option>
                @foreach ($dataObjResource as $row)
                    <option value="{{ $row->id }}" {{ isset($dataObj) && $dataObj->resource_id == $row->id || old('permissions_resource_id') == $row->id ? 'selected' : '' }}>
                        {{ $row->name_jp }}
                    </option>
                @endforeach
            @endif
        </select>

        @error('permissions_resource_id')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </div>
</div>

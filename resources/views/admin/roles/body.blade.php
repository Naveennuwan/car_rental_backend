

<div class="form-group row">
    <label for="roles_name" class="form-label col-3 col-sm-3 col-md-2">@lang('general.common.name')
        <span class="text-danger">*</span></label>
    <div class="col-9 col-sm-9 col-md-10">
        <input type="text" class="form-control @error('roles_name') is-invalid @enderror" id="roles_name"
            name="roles_name" placeholder="@lang('general.common.name')"
            value="{{ Request::old('roles_name', $dataObj->name ?? '') }}" maxlength="255">
        @error('roles_name')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <h5 class="mt-2 pt-50">Role Permissions <span class="text-danger">*</span></h5>
    </div>
</div>
<div class="form-group row">
    <label for="roles_name" class="form-label col-4 col-sm-4 col-md-2">Administrator Access</label>
    <div class="col-8 col-sm-8 col-md-9">
        <input type="checkbox" id="selectAll" name="selectAll" class="form-check-input" />
        <label class="form-label" for="selectAll">Select All</label>
    </div>
</div>
<div class="form-group row">
    <!-- Permission table -->
    @error('permission_ids')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <div class="table-responsive">
        <table class="table table-flush-spacing">
            <tbody id="table_check">
                @foreach ($permissions_array as $resource => $permission)
                    <tr>
                        @dump($permission)
                        <td style="width: 15%" class="text-nowrap fw-bolder">{{ $resource }} </td>
                        <td style="width: 85%">
                            <div class="d-flex">
                                @foreach ($permission as $key => $value)
                                    <div class="form-check me-2 me-lg-3" style="text-align: left; width: 20%;">
                                        <input class="form-check-input" type="checkbox" name="permission_ids[]"
                                            id="{{ $key }}" value="{{ $key }}"
                                            {{ in_array($key, old('permission_ids', [])) || in_array($key, $existing_permissions_array) ? 'checked' : '' }} />
                                        <label class="form-check-label" for="{{ $key }}">{{ $value }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Permission table -->
</div>

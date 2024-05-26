<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <!-- Use full width on small screens, and half on large screens -->
        <div class="form-group row">
            <label for="users_name" class="form-label col-3 col-sm-3 col-md-4">@lang('users.last_name')
                <span class="text-danger">*</span></label>
            <div class="col-9 col-sm-9 col-md-8">
                <input type="text" class="form-control @error('users_name') is-invalid @enderror" id="users_name"
                    name="users_name" placeholder="@lang('users.last_name')"
                    value="{{ Request::old('users_name', $user->name ?? '') }}" maxlength="255"
                    onkeydown="return /[a-z]/i.test(event.key)">
                @error('users_name')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <!-- Use full width on small screens, and half on large screens -->
        <div class="form-group row">
            <label for="users_first_name" class="form-label col-3 col-sm-3 col-md-4">@lang('users.first_name')
                <span class="text-danger">*</span></label>
            <div class="col-9 col-sm-9 col-md-8">
                <input type="text" class="form-control @error('users_first_name') is-invalid @enderror"
                    id="users_first_name" name="users_first_name" placeholder="@lang('users.first_name')"
                    value="{{ Request::old('users_first_name', $user->first_name ?? '') }}" maxlength="255"
                    onkeydown="return /[a-z]/i.test(event.key)">
                @error('users_first_name')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="users_email" class="form-label col-3 col-sm-3 col-md-2"> @lang('general.common.email')
        <span class="text-danger">*</span></label>
    <div class="col-9 col-sm-9 col-md-10">
        <input type="email" class="form-control @error('users_email') is-invalid @enderror" id="users_email"
            name="users_email" placeholder="@lang('general.common.email')"
            value="{{ Request::old('users_email', $user->email ?? '') }}">
        @error('users_email')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="users_password" class="form-label col-3 col-sm-3 col-md-2">@lang('general.common.password')
        <span class="text-danger">*</span></label>
    <div class="col-9 col-sm-9 col-md-10">
        <div class="input-group">
            <input type="password" class="form-control @error('users_password') is-invalid @enderror"
                id="users_password" name="users_password" placeholder="@lang('general.common.password')"
                value="{{ Request::old('users_password') ?: '' }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="showPasswordToggle">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
            @error('users_password')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

    </div>
</div>
<div class="form-group row">
    <label for="users_password_confirmation" class="form-label col-3 col-sm-3 col-md-2">@lang('general.common.password_confirmation')
        <span class="text-danger">*</span></label>
    <div class="col-9 col-sm-9 col-md-10">
        <div class="input-group">
            <input type="password" class="form-control @error('users_password_confirmation') is-invalid @enderror"
                id="users_password_confirmation" name="users_password_confirmation" placeholder="@lang('general.common.password_confirmation')"
                value="{{ Request::old('users_password_confirmation') ?: '' }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="showPasswordConfirmationToggle">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
            @error('users_password_confirmation')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="users_role_id" class="form-label col-3 col-sm-3 col-md-2" aria-required="true">
        @lang('rolesLng.form_title') <span class="text-danger">*</span>
    </label>
    <div class="col-9 col-sm-9 col-md-10">
        <select class="js-example-basic-multiple form-control @error('users_role_id') is-invalid @enderror"
            id="users_role_id" name="users_role_id[]" multiple>
            @foreach ($roles as $row)
                <option value="{{ $row->id }}"
                    @if (isset($user)) @if (in_array(
                            $row->id,
                            $user->roles()->pluck('role_id')->toArray())) selected @endif @endif>
                    {{ $row->name }}
                </option>
            @endforeach
        </select>
        @error('users_role_id')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="users_permission_id" class="form-label col-3 col-sm-3 col-md-2"
        aria-required="true">@lang('users.direct_permissions')</label>
    <div class="col-9 col-sm-9 col-md-10">
        <select class="js-example-basic-multiple form-control @error('users_permission_id') is-invalid @enderror"
            id="users_permission_id" name="users_permission_id[]" multiple>
            @if (count($permissions))
                @foreach ($permissions as $row)
                    <option value="{{ $row->id }}"
                        @if (isset($user)) @if (in_array(
                                $row->id,
                                $user->permissions()->pluck('permission_id')->toArray()))
                            selected @endif
                        @endif
                        >
                        {{ $row->name }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>

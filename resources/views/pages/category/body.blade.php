<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group row">
            <label for="categories_name" class="form-label col-3 col-sm-3 col-md-4">@lang('categoryLng.name')
                <span class="text-danger">*</span></label>
            <div class="col-9 col-sm-9 col-md-8">
                <input type="text" class="form-control @error('categories_name') is-invalid @enderror"
                    id="categories_name" name="categories_name" placeholder="@lang('categoryLng.name')"
                    value="{{ Request::old('categories_name', $categoryObj->name ?? '') }}" maxlength="255">
                @error('categories_name')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group row">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" id="categories_isDisplay" name="categories_isDisplay" value="1"
                        {{ Request::old('categories_isDisplay', isset($categoryObj) && $categoryObj->isDisplay ? '1' : '') == '1' ? 'checked' : '' }}>
                </div>
            </div>
            <label for="users_first_name" class="form-label col-3 col-sm-3 col-md-4">@lang('categoryLng.display')</label>
        </div>
    </div>
</div>

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $("#categories_isDisplay").on("change", function() {
                var input = this;
                var isChecked = $(input).prop("checked");
                $isDisplayValue = isChecked ? 1 : 0
                $(input).val($isDisplayValue);
            });
        });
    </script>
@endpush

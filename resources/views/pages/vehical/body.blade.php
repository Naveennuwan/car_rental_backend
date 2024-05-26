<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group row">
            <label for="shop_name" class="form-label col-3 col-sm-3 col-md-4">Vehicle Name
                <span class="text-danger">*</span></label>
            <div class="col-9 col-sm-9 col-md-8">
                <input type="text" class="form-control @error('shop_name') is-invalid @enderror"
                    id="shop_name" name="name" placeholder="Vehicle Name"
                    value="{{ Request::old('shop_name', $dataObj->name ?? '') }}" maxlength="255">
                @error('shop_name')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group row">
            <label for="users_first_name" class="form-label col-3 col-sm-3 col-md-4">Is Active</label>
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" id="isDisplay" name="isDisplay" value="1"
                        {{ Request::old('isDisplay', isset($dataObj) && $dataObj->isDisplay ? '1' : '') == '1' ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group row">
            <label for="shop_name" class="form-label col-3 col-sm-3 col-md-4">Vehicle Name
                <span class="text-danger">*</span></label>
            <div class="col-9 col-sm-9 col-md-8">
            <select class="js-example-basic-multiple form-control" id="category_id" name="category_id">

                <option value="" selected>select a category</option>
                    @if (count($categoryObj))
                        @foreach ($categoryObj as $row)

                            <option
                            {{ old('category_id', isset($dataObj) && $dataObj->category_id == $row->id ? $row->id : '') == $row->id ? 'selected' : '' }}
                            value="{{ $row->id }}">
                            {{ $row->name }}
                        </option>

                        
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group row">
            <label for="vehicle_number" class="form-label col-3 col-sm-3 col-md-4">vehicle_number
                <span class="text-danger">*</span></label>
            <div class="col-9 col-sm-9 col-md-8">
                <input type="text" class="form-control @error('vehicle_number') is-invalid @enderror"
                    id="vehicle_number" name="vehicle_number" placeholder="vehicle_number"
                    value="{{ Request::old('vehicle_number', $dataObj->vehicle_number ?? '') }}" maxlength="255">
                @error('vehicle_number')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group row">
            <label for="model" class="form-label col-3 col-sm-3 col-md-4">model</label>
            <div class="col-9 col-sm-9 col-md-8">
                <input type="text" class="form-control @error('model') is-invalid @enderror"
                    id="model" name="model" placeholder="model"
                    value="{{ Request::old('model', $dataObj->model ?? '') }}" maxlength="255">
                @error('model')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group row">
            <label for="year" class="form-label col-3 col-sm-3 col-md-4">year
                <span class="text-danger">*</span></label>
            <div class="col-9 col-sm-9 col-md-8">
                <input type="text" class="form-control @error('year') is-invalid @enderror"
                    id="year" name="year" placeholder="year"
                    value="{{ Request::old('year', $dataObj->year ?? '') }}" maxlength="255">
                @error('year')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group row">
            <label for="price" class="form-label col-3 col-sm-3 col-md-4">Price
                <span class="text-danger">*</span></label>
            <div class="col-9 col-sm-9 col-md-8">
                <input type="text" class="form-control @error('price') is-invalid @enderror"
                    id="price" name="price" placeholder="price"
                    value="{{ Request::old('price', $dataObj->price ?? '') }}" maxlength="255">
                @error('price')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 col-sm-12">
        <label for="vehical_image">image<span class="text-danger">*</span></label>
        <div class="image-preview-area">
            {{-- @php
                if ($vehicleObj && File::exists(public_path('images/vehical_image/' . $vehicleObj->main_image))) {
                    $main_image_path = asset('images/vehical_image/' . $vehicleObj->main_image);
                } else {
                    $main_image_path = '';
                }
            @endphp --}}
            @php
                if (Request::old('delete_main_flag') == 0) {
                    $src = old(
                        'vehical_image',
                        isset($vehicleObj) &&
                        File::exists(public_path('images/vehical_image/' . $vehicleObj->main_image))
                            ? asset('images/vehical_image/' . $vehicleObj->main_image)
                            : '',
                    );
                } else {
                    $src = '';
                }
            @endphp
            {{-- <img id="image-preview-area" commanID="-main" name="vehical_image" src="{{ $main_image_path }}"
                alt="" width="100%" /> --}}
            <img id="image-preview-area" class="images-size" name="vehical_image" src="{{ $src }}"
                alt="" width="100%" />
        </div>
        <input type="hidden" class="form-control" name="delete_main_flag" value="0" id="delete-main-flag">
        <input type="hidden" class="form-control @error('vehical_image') is-invalid @enderror">
        @error('vehical_image')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
        <div class="d-flex align-items-baseline">
            <div class="btn-group mt-1 mr-2" role="group">
                <label for="main-image-upload"
                    class="btn btn-sm bg-red fixed-width-button-100">@lang('productLng.add_btn')</label>
                <input type="file" accept="image/*" name="vehical_image" id="main-image-upload"
                    commanID="-main" style="display: none;" />
            </div>
            <div class="btn-group mr-1 mt-2" role="group">
                <label for="main-image-delete"
                    class="btn btn-sm bg-grey fixed-width-button-100">@lang('productLng.delete_btn')</label>
                <input id="main-image-delete" type="delete" class="btn btn-sm bg-grey fixed-width-button-100"
                    style="display: none;" />
            </div>
        </div>
    </div>
</div>



<!-- <div class="form-row">
    <div class="form-group col-12 col-sm-12">
        <label for="products_other_image">@lang('productLng.other_image')</label>
        <div class="d-flex flex-row flex-wrap">
            @for ($i = 1; $i <= 4; $i++)
                <div class="mr-3">
                    <div class="image-preview-area" name="products_other_image_{{ $i }}">
                        @php
                            $field_name = 'other_image_' . str_pad($i, 2, '0', STR_PAD_LEFT); // Format the field name with leading zeros
                            $other_image_path =
                                $vehicleObj &&
                                isset($vehicleObj->$field_name) &&
                                File::exists(
                                    public_path(
                                        'images/product_images/other_image/' . $i . '/' . $vehicleObj->$field_name,
                                    ),
                                )
                                    ? asset('images/product_images/other_image/' . $i . '/' . $vehicleObj->$field_name)
                                    : '';
                        @endphp

                        <img id="products_other_image_{{ $i }}" class="images-size"
                            name="vehical_image" src="{{ $other_image_path }}" alt=""
                            width="100%" />
                    </div>
                    <div class="d-flex align-items-baseline">
                        <div class="btn-group mt-1 mr-2" role="group">
                            <label for="other-image-{{ $i }}-upload"
                                class="btn btn-sm bg-red fixed-width-button-100">@lang('productLng.add_btn')</label>
                            <input type="file" accept="image/*" name="products_other_image_{{ $i }}"
                                id="other-image-{{ $i }}-upload" style="display: none;" />
                        </div>
                        <div class="btn-group mr-1 mt-2" role="group">
                            <label for="other-image-{{ $i }}-delete"
                                class="btn btn-sm bg-grey fixed-width-button-100">@lang('productLng.delete_btn')</label>
                            <input id="other-image-{{ $i }}-delete" type="delete"
                                class="btn btn-sm bg-grey fixed-width-button-100" style="display: none;" />
                        </div>
                    </div>
                </div>
            @endfor

        </div>
    </div>
</div> -->

@push('css')
    <style>
        .select2-container .select2-selection--single {
            height: 38px;
        }

        .images-size {
            min-height: 250px;
            max-height: 250px;
        }

        .image-preview-area {
            height: 250px;
            width: 230px;
            background-color: #dce2e8;
        }

        .black-heading {
            background-color: #000000;
            margin: 2px;
        }

        .black-heading-text {
            color: #ffffff;
        }

        .red-border {
            border: 1px solid red;
        }

        .green-border {
            border: 1px solid green;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $("#isDisplay").on("change", function() {
                var input = this;
                var isChecked = $(input).prop("checked");
                $isDisplayValue = isChecked ? 1 : 0
                $(input).val($isDisplayValue);
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $("#main-image-upload").on("change", function() {
            $("#delete-main-flag").val('0');
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $("#image-preview-area").attr("src", e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        });
        $("#main-image-delete").on("click", function(e) {
            e.preventDefault();
            $("#image-preview-area").attr("src", "");
            $("#image-preview-area").val('');
            $("#delete-main-flag").val('1');
        });
    });
</script>
@endpush

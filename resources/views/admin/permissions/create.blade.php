@extends('layouts.app')

@section('title', __('permissionsLng.form_title'))

@section('toolbar')
    <div class="toolbar">
        <div class="row col-12 col-sm-12 col-md-12">
            <div class="col-12 col-sm-5 col-md-6">
                <h6 class="text-muted">@lang('general.nav.user_managment') / @lang('permissionsLng.form_title') / @lang('general.common.create')</h6>
            </div>
            <div class="col-12 col-sm-7 col-md-6 text-right">
                <div class="btn-toolbar justify-content-end text-right" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group">
                        <a id="back-btn" href="{{ route('admin.permissions.index') }}"
                            class="btn btn-sm bg-back fixed-width-button-100">@lang('general.form.back_btn')</a>
                    </div>
                    <div class="btn-group mr-2" role="group">
                        <button id="save-btn" class="btn btn-sm bg-red fixed-width-button-100">@lang('general.form.save_changes') </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <br />
                        <form method="post" action="{{ route('admin.permissions.store') }}" name="addForm" id="addForm"
                            data-parsley-validate class="form-horizontal form-label-left">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    @include('admin.permissions.body')
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .select2-container .select2-selection--single {
            height: 38px;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $(".js-example-basic-multiple").select2();
            $(".js-example-basic-single").select2();
            $('#save-btn').on('click', function() {
                $('#addForm').submit();
            });
        });
    </script>
@endpush

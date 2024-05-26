@extends('layouts.app')

@section('title', __('vehicalLng.form_title'))

@section('toolbar')
    <div class="toolbar">
        <div class="row col-12 col-sm-12 col-md-12">
            <div class="col-12 col-sm-5 col-md-6">
                <h6 class="text-muted">@lang('general.nav.master_control') / @lang('vehicalLng.form_title') / @lang('general.common.create')</h6>
            </div>
            <div class="col-12 col-sm-7 col-md-6 text-right">
                <div class="btn-toolbar justify-content-end text-right" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group">
                        <a href="{{ route('vehical.index') }}"
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
                        <form method="post" action="{{ route('vehical.store') }}" name="addForm" id="addForm"
                            data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    @include('pages.vehical.body')
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
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('#save-btn').on('click', function() {
                $('#addForm').submit();
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('title', __('vehicalLng.form_title'))

@section('toolbar')
    <div class="toolbar">
        <div class="row col-12 col-sm-12 col-md-12">
            <div class="col-12 col-sm-5 col-md-6">
                <h6 class="text-muted">@lang('general.nav.master_control') / @lang('vehicalLng.form_title') / @lang('general.common.delete')</h6>
            </div>
            <div class="col-12 col-sm-7 col-md-6 text-right">
                <div class="btn-toolbar justify-content-end text-right" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group">
                        <a href="{{ route('vehical.index') }}"
                            class="btn btn-sm bg-back fixed-width-button-100">@lang('general.form.back_btn')</a>
                    </div>
                    <div class="btn-group mr-2" role="group">
                        <button id="delete-btn" class="btn btn-sm bg-grey fixed-width-button-100" data-toggle="modal"
                            data-target="#deleteModal">@lang('general.form.delete_record')</button>
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
                        <form method="POST" action="{{ route('vehical.destroy', $dataObj->id) }}" name="deleteForm"
                            id="deleteForm">
                            @csrf
                            @method('delete')
                            <div class="card">
                                <div class="card-body">
                                    @include('pages.vehical.body')
                                </div>
                            </div>
                        </form>
                        <div class="">
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-black">
                                            <button type="button" class="close bg-white-font" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center mt-3 mb-3">
                                            <h6 class="modal-title" id="deleteModalTitle">顧客情報を削除しますか?</h6>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm bg-grey fixed-width-button-100"
                                                data-dismiss="modal">@lang('general.form.cancel_btn')</button>
                                            <button type="button" class="btn btn-sm bg-red fixed-width-button-100"
                                                onclick="deleteSubmit()">Ok</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        disabledForm();
    });

    function disabledForm() {
        var input_text = document.querySelectorAll('input[type="text"]');
        for (var i = 0; i < input_text.length; i++) {
            input_text[i].disabled = true;
        }

        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].disabled = true;
        }

        var input_file = document.querySelectorAll('input[type="file"]');
        for (var i = 0; i < input_file.length; i++) {
            input_file[i].disabled = true;
        }

        var input_delete = document.querySelectorAll('input[type="delete"]');
        for (var i = 0; i < input_delete.length; i++) {
            input_delete[i].disabled = true;
        }

    }
</script>
    <script>
        $(document).ready(function() {
            $('#delete-btn').on('click', function() {
                $('#deleteModal').modal('show');
            });
        });

        function deleteSubmit() {
            document.getElementById("deleteForm").submit();
        }
    </script>
@endpush

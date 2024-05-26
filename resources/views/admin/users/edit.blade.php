@extends('layouts.app')

@section('title', 'Users')

@section('toolbar')
    <div class="toolbar">
        <div class="row col-12 col-sm-12 col-md-12">
            <div class="col-12 col-sm-5 col-md-6">
                <h6 class="text-muted">@lang('general.nav.user_managment') / @lang('general.nav.users') / @lang('general.common.edit')</h6>
            </div>
            <div class="col-12 col-sm-7 col-md-6 text-right">
                <div class="btn-toolbar justify-content-end text-right" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group">
                        <a id="back-btn" href="{{ route('admin.users.index') }}"
                            class="btn btn-sm bg-back fixed-width-button-100">@lang('general.form.back_btn')</a>
                    </div>
                    <div class="btn-group mr-2" role="group">
                        <button id="save-btn" class="btn btn-sm bg-red fixed-width-button-100"
                            value="edit">@lang('general.form.save_changes') </button>
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
                        <form method="post" action="{{ route('admin.users.update', $user->id) }}" name="editForm"
                            id="editForm">
                            @csrf
                            @method('PUT')
                            <div class="card">
                                <div class="card-body">
                                    @include('admin.users.body')
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
            $(".js-example-basic-multiple").select2();
            $(".js-example-basic-single").select2();
            $('#save-btn').on('click', function() {
                $('#editForm').submit();
            });
            $('#showPasswordToggle').click(function() {
                var passwordInput = $('#users_password');
                var type = passwordInput.attr('type');
                if (type === 'password') {
                    passwordInput.attr('type', 'text');
                } else {
                    passwordInput.attr('type', 'password');
                }
            });
            $('#showPasswordConfirmationToggle').click(function() {
                var passwordInput = $('#users_password_confirmation');
                var type = passwordInput.attr('type');
                if (type === 'password') {
                    passwordInput.attr('type', 'text');
                } else {
                    passwordInput.attr('type', 'password');
                }
            });
        });
    </script>
@endpush

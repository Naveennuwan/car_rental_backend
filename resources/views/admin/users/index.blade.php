@extends('layouts.app')

@section('title', 'Users')

@section('toolbar')
    <div class="toolbar">
        <div class="row col-12 col-sm-12 col-md-12">
            <div class="col-12 col-sm-5 col-md-6">
                <h6 class="text-muted">@lang('general.nav.user_managment') / @lang('general.nav.users') / @lang('general.common.list')</h6>
            </div>
            <div class="col-12 col-sm-7 col-md-6 text-right">
                <div class="btn-toolbar justify-content-end text-right" role="toolbar" aria-label="Toolbar with button groups">
                    @include('components.toolbar')
                    <div class="btn-group" role="group">
                        <a id="create-btn" href="{{ route('admin.users.create') }}"
                            class="btn btn-sm bg-red fixed-width-button-100 @cannot('user-create') disabled @endcannot">@lang('general.form.create_record')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="">
        <form action="{{ route('admin.users.searchUsers') }}" method="post" id="searchForm">
            @csrf
            <div class="card">
                <input type="hidden" id="userIdInput">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <p class="text-muted">@lang('general.common.search_record')...</p>
                        <div>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm fixed-width-button-200"
                                style="background-color: #8e6565; color: #fff;">@lang('general.app.reset')</a>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12 col-sm-4">
                            <label for="search_name">@lang('users.last_name')</label>
                            <input type="text" class="form-control" id="search_name" name="search_name"
                                placeholder="@lang('users.last_name')"
                                value="{{ Request::old('search_name', $searchingVals['name'] ?? '') }}" maxlength="255"
                                onkeydown="return /[a-z]/i.test(event.key)">
                        </div>
                        <div class="form-group col-12 col-sm-4">
                            <label for="search_first_name">@lang('users.first_name')</label>
                            <input type="text" class="form-control" id="search_first_name" name="search_first_name"
                                placeholder="@lang('users.first_name')"
                                value="{{ Request::old('search_first_name', $searchingVals['first_name'] ?? '') }}"
                                maxlength="255" onkeydown="return /[a-z]/i.test(event.key)">
                        </div>

                        <div class="form-group col-12 col-sm-4">
                            <label for="search_email">@lang('general.common.email')</label>
                            <input type="text" class="form-control" id="search_email" name="search_email"
                                placeholder="@lang('general.common.email')"
                                value="{{ Request::old('search_email', $searchingVals['email'] ?? '') }}" maxlength="255">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="">
        <form action="{{ route('admin.users.exportUsers') }}" method="post" id="exportForm">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="table-div">
                        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>@lang('users.last_first_name')</th>
                                    <th>@lang('general.common.email')</th>
                                    <th class="d-none d-sm-table-cell">@lang('general.nav.roles')</th>
                                    <th class="d-none d-sm-table-cell">@lang('users.direct_permissions')</th>
                                    <th class="d-none d-sm-table-cell">@lang('general.common.isActive')</th>
                                    <th>@lang('general.form.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td><input type="checkbox" class="checkSingle" id="check_id" name="check_id[]"
                                                value="{{ $user->id }}"></td>
                                        <td>{{ $user->name }} {{ $user->first_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="d-none d-sm-table-cell">
                                            @foreach ($user->roles as $user_role)
                                                <span class="badge badge-secondary">{{ $user_role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            @foreach ($user->permissions as $user_permissions)
                                                <span class="badge badge-secondary">{{ $user_permissions->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="custom-switch">
                                                <input type="checkbox" id="customSwitch{{ $user->id }}"
                                                    class="custom-switch-input"
                                                    @if ($user->deleted_at === null) checked @endif
                                                    @cannot('user-delete') disabled @endcannot>
                                                <label class="custom-switch-label"
                                                    for="customSwitch{{ $user->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a id="edit-btn" href="{{ route('admin.users.edit', $user->id) }}"
                                                class="btn btn-sm bg-red @cannot('user-edit') disabled @endcannot"><i
                                                    class="fas fa-pencil" title="@lang('general.form.edit_record')"></i>
                                                @lang('general.form.edit_record')</a>

                                            <a id="delete-btn" href="{{ route('admin.users.show', $user->id) }}"
                                                class="btn btn-sm bg-grey @cannot('user-delete') disabled @endcannot"><i
                                                    class="fas fa-trash" title="@lang('general.form.delete_record')"></i>
                                                @lang('general.form.delete_record')</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="">
        <!-- Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
            aria-labelledby="confirmationModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-black">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="close bg-white-font" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center mt-3 mb-3">
                        <h6 class="modal-title" id="confirmationText"></h6>
                    </div>
                    <div class="modal-footer">
                        <button id="cancel-btn-modal" type="button" class="btn btn-sm bg-grey fixed-width-button-100"
                            data-dismiss="modal" onclick="modal_cancel_btn()">@lang('general.form.cancel_btn')</button>
                        <button id="confirmAction" type="button"
                            class="btn btn-sm bg-red fixed-width-button-100">@lang('general.form.confirm_btn')</button>
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
        window.translations = @json(__('general.form.flash'));
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check All functionality
            document.getElementById('checkAll').addEventListener('change', function() {
                var checkboxes = document.getElementsByClassName('checkSingle');
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = this.checked;
                }
            });

            // Individual checkbox event handling
            var checkboxes = document.getElementsByClassName('checkSingle');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].addEventListener('change', function() {
                    document.getElementById('checkAll').checked = false;
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#search-btn').on('click', function() {
                $('#searchForm').submit();
            });

            $('#export-btn').on('click', function() {
                $('#exportForm').submit();
            });
        });

        var switchStates = {};
        var currentSwitchStates = {};

        $('.custom-switch-input').change(function() {
            var userId = $(this).attr('id').replace('customSwitch', '');
            var $userIdInput = $('#userIdInput');
            var $customSwitch = $('#customSwitch' + userId);

            // Store the current state
            var isChecked = $(this).prop('checked');
            currentSwitchStates[userId] = isChecked;

            // Store the previous state
            var isCheckedVal = isChecked ? 0 : 1;
            switchStates[userId] = isCheckedVal;

            // Set the confirmation text based on the switch state
            var confirmationText = isChecked ? window.translations.do_you_want_activate : window.translations
                .do_you_want_deactivate;

            $('#confirmationText').text(confirmationText);

            $userIdInput.val(userId);

            $('#confirmationModal').modal('show');
        });

        $('#confirmAction').click(function() {
            var userId = $('#userIdInput').val();
            var $customSwitch = $('#customSwitch' + userId);
            $.ajax({
                url: '/admin/update-user-status/' + userId,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: switchStates[userId]
                },
                success: function(response) {
                    $customSwitch.prop('checked', currentSwitchStates[userId]);
                    if (currentSwitchStates[userId] == 1) {
                        toastr.success(window.translations.record_activated);
                    } else {
                        toastr.warning(window.translations.record_deactivated);
                    }
                    console.log(response);
                },
                error: function(error) {
                    toastr.error('Failed to update user status. Please try again.');
                    console.error(error);
                }
            });

            $('#confirmationModal').modal('hide');
        });

        function modal_cancel_btn() {
            var userId = $('#userIdInput').val();
            var $customSwitch = $('#customSwitch' + userId);
            $customSwitch.prop('checked', switchStates[userId]);
            var modal = document.getElementById("confirmationModal");
            modal.style.display = "none";
        }
    </script>
@endpush

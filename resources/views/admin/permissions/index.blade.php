@extends('layouts.app')

@section('title', __('permissionsLng.form_title'))

@section('toolbar')
    <div class="toolbar">
        <div class="row col-12 col-sm-12 col-md-12">
            <div class="col-12 col-sm-5 col-md-6">
                <h6 class="text-muted">@lang('general.nav.user_managment') / @lang('permissionsLng.form_title') / @lang('general.common.list')</h6>
            </div>
            <div class="col-12 col-sm-7 col-md-6 text-right">
                <div class="btn-toolbar justify-content-end text-right" role="toolbar" aria-label="Toolbar with button groups">
                    @include('components.toolbar')
                    <div class="btn-group" role="group">
                        <a id="create-btn" href="{{ route('admin.permissions.create') }}"
                            class="btn btn-sm bg-red fixed-width-button-100 @cannot('permission-create') disabled @endcannot">
                            @lang('general.form.create_record')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="">
        <form action="{{ route('admin.permissions.search') }}" method="post" id="searchForm">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <p class="text-muted">@lang('general.common.search_record')...</p>
                        <div>
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm fixed-width-button-200"
                                style="background-color: #8e6565; color: #fff;">@lang('general.app.reset')</a>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12 col-sm-4 col-md-4">
                            <label for="search_name">@lang('general.common.name')</label>
                            <input type="text" class="form-control" id="search_name" name="search_name"
                                placeholder="@lang('general.common.name')"
                                value="{{ Request::old('search_name', $searchingVals['name'] ?? '') }}" maxlength="255">
                        </div>

                        <div class="form-group col-12 col-sm-4 col-md-4">
                            <label for="search_resource_id">
                                @lang('permissionsLng.permissions_resource_id')
                            </label>
                            <select class="js-example-basic-single form-control" id="search_resource_id"
                                name="search_resource_id">
                                <option value="" selected disabled>@lang('Select a Resource')</option>
                                @if (count($dataObjResource))
                                    @foreach ($dataObjResource as $row)
                                        <option value="{{ $row->id }}"
                                            {{ $row->id == optional($searchingVals)['resource_id'] ? 'selected="selected"' : '' }}>
                                            {{ $row->name_jp }}</option>
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="">
        <form action="{{ route('admin.permissions.export') }}" method="post" id="exportForm">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="table-div">
                        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>@lang('general.common.name')</th>
                                    <th>@lang('permissionsLng.permissions_resource_id')</th>
                                    <th>@lang('general.form.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataObj as $row)
                                    <tr>
                                        <td><input type="checkbox" class="checkSingle" id="check_id" name="check_id[]"
                                                value="{{ $row->id }}"></td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->resource->name }}</td>
                                        <td>
                                            <a id="edit-btn" href="{{ route('admin.permissions.edit', $row->id) }}"
                                                class="btn btn-sm bg-red @cannot('permission-edit') disabled @endcannot"><i
                                                    class="fas fa-pencil" title="@lang('general.form.edit_record')"></i>
                                                @lang('general.form.edit_record')</a>

                                            <a id="delete-btn" href="{{ route('admin.permissions.show', $row->id) }}"
                                                class="btn btn-sm bg-grey @cannot('permission-delete') disabled @endcannot"><i
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
    </script>
@endpush

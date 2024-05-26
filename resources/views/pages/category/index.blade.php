@extends('layouts.app')

@section('title', __('categoryLng.form_title'))

@section('toolbar')
    <div class="toolbar">
        <div class="row col-12 col-sm-12 col-md-12">
            <div class="col-12 col-sm-5 col-md-6">
                <h6 class="text-muted">@lang('general.nav.master_control') / @lang('categoryLng.form_title') / @lang('general.common.list')</h6>
            </div>
            <div class="col-12 col-sm-7 col-md-6 text-right">
                <div class="btn-toolbar justify-content-end text-right" role="toolbar" aria-label="Toolbar with button groups">
                    @include('components.toolbar', ['showExportButton' => false])
                    <div class="btn-group" role="group">
                        <a href="{{ route('category.create') }}"
                            class="btn btn-sm create-btn-color fixed-width-button-100 @cannot('category-create') disabled @endcannot">@lang('general.form.create_record')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="">
        <form action="{{ route('category.search') }}" method="post" id="searchForm" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <p class="text-muted">@lang('general.common.search_record')...</p>
                        <div>
                            <a href="{{ route('category.index') }}" class="btn btn-sm fixed-width-button-200"
                                style="background-color: #e1dfdf; color: #757575;">@lang('general.app.reset')</a>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12 col-sm-2">
                            <label for="search_id">@lang('categoryLng.id')</label>
                            <input type="text" class="form-control" id="search_id" name="search_id"
                                placeholder="@lang('categoryLng.id')"
                                value="{{ Request::old('search_id', $searchingVals['id'] ?? '') }}" maxlength="255">
                        </div>
                        <div class="form-group col-12 col-sm-5">
                            <label for="search_name">@lang('categoryLng.name')</label>
                            <input type="text" class="form-control" id="search_name" name="search_name"
                                placeholder="@lang('categoryLng.name')"
                                value="{{ Request::old('search_name', $searchingVals['name'] ?? '') }}" maxlength="255">
                        </div>
                        <div class="form-group col-12 col-sm-2 col-md-2">
                            <label for="search_display">
                                @lang('categoryLng.display')
                            </label>
                            <select class="js-example-basic-single form-control" id="search_display" name="search_display">
                                <option value="" selected>@lang('categoryLng.all')</option>
                                <option value="1"
                                    {{ Request::old('search_display', $searchingVals['isDisplay'] ?? '') == '1' ? 'selected' : '' }}>
                                    @lang('categoryLng.grid_display')</option>
                                <option value="0"
                                    {{ Request::old('search_display', $searchingVals['isDisplay'] ?? '') == '0' ? 'selected' : '' }}>
                                    @lang('categoryLng.grid_hidden')</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="">
        <form action="{{ route('category.export') }}" method="post" id="exportForm">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="table-div">
                        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>@lang('categoryLng.id')</th>
                                    <th style="width:50%">@lang('categoryLng.name')</th>
                                    <th>@lang('categoryLng.display')</th>
                                    <th>@lang('general.form.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categoryObj as $row)
                                    <tr>
                                        <td><input type="checkbox" class="checkSingle" id="check_id" name="check_id[]"
                                                value="{{ $row->id }}"></td>
                                        <td>{{ $row->id }}
                                        </td>
                                        <td id="category-name">{{ $row->name }}
                                        </td>
                                        <td>
                                            @if ($row->isDisplay === 1)
                                                <p class="font-weight-bold">@lang('categoryLng.grid_display')</p>
                                            @else
                                                <p class="font-weight-light">@lang('categoryLng.grid_hidden')</p>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('category.edit', $row->id) }}"
                                                class="btn btn-sm edit-btn-color @cannot('category-edit') disabled @endcannot"><i
                                                    class="fas fa-pencil" title="@lang('general.form.edit_record')"></i>
                                                @lang('general.form.edit_record')</a>

                                            <a href="{{ route('category.show', $row->id) }}"
                                                class="btn btn-sm delete-btn-color @cannot('category-delete') disabled @endcannot"><i
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

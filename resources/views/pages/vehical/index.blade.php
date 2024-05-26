@extends('layouts.app')

@section('title', __('vehicalLng.form_title'))

@section('toolbar')
    <div class="toolbar">
        <div class="row col-12 col-sm-12 col-md-12">
            <div class="col-12 col-sm-5 col-md-6">
                <h6 class="text-muted">@lang('general.nav.master_control') / @lang('vehicalLng.form_title') / @lang('general.common.list')</h6>
            </div>
            <div class="col-12 col-sm-7 col-md-6 text-right">
                <div class="btn-toolbar justify-content-end text-right" role="toolbar" aria-label="Toolbar with button groups">
                    @include('components.toolbar')
                    <div class="btn-group" role="group">
                        <a href="{{ route('vehical.create') }}"
                            class="btn btn-sm bg-red fixed-width-button-100 ">@lang('general.form.create_record')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="">
        <form action="{{ route('vehical.search') }}" method="post" id="searchForm" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <p class="text-muted">@lang('general.common.search_record')...</p>
                        <div>
                            <a href="{{ route('vehical.index') }}" class="btn btn-sm fixed-width-button-200"
                                style="background-color: #8e6565; color: #fff;">@lang('general.app.reset')</a>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12 col-sm-2">
                            <label for="search_id">@lang('vehicalLng.id')</label>
                            <input type="text" class="form-control" id="search_id" name="search_id"
                                placeholder="@lang('vehicalLng.id')"
                                value="{{ Request::old('search_id', $searchingVals['id'] ?? '') }}" maxlength="255">
                        </div>
                        <div class="form-group col-12 col-sm-5">
                            <label for="search_name">@lang('vehicalLng.name')</label>
                            <input type="text" class="form-control" id="search_name" name="search_name"
                                placeholder="@lang('vehicalLng.name')"
                                value="{{ Request::old('search_name', $searchingVals['name'] ?? '') }}" maxlength="255">
                        </div>
                        <div class="form-group col-12 col-sm-2 col-md-2">
                            <label for="search_display">
                                @lang('vehicalLng.display')
                            </label>
                            <select class="js-example-basic-single form-control" id="search_display" name="search_display">
                                <option value="" selected>@lang('vehicalLng.all')</option>
                                <option value="1"
                                    {{ Request::old('search_display', $searchingVals['isDisplay'] ?? '') == '1' ? 'selected' : '' }}>
                                    @lang('vehicalLng.grid_display')</option>
                                <option value="0"
                                    {{ Request::old('search_display', $searchingVals['isDisplay'] ?? '') == '0' ? 'selected' : '' }}>
                                    @lang('vehicalLng.grid_hidden')</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="">
        <form action="{{ route('vehical.export') }}" method="post" id="exportForm">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="table-div">
                        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>id</th>
                                    <th style="width:50%">vehical name</th>
                                    <th>display</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataObj as $row)
                                    <tr>
                                        <td><input type="checkbox" class="checkSingle" id="check_id" name="check_id[]"
                                                value="{{ $row->id }}"></td>
                                        <td>{{ $row->id }}
                                        </td>
                                        <td id="vehical-name">{{ $row->name }}
                                        </td>
                                        <td>
                                            @if ($row->isDisplay === 1)
                                                <p class="font-weight-bold">@lang('vehicalLng.grid_display')</p>
                                            @else
                                                <p class="font-weight-light">@lang('vehicalLng.grid_hidden')</p>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('vehical.edit', $row->id) }}"
                                                class="btn btn-sm bg-red"><i
                                                    class="fas fa-pencil" title="@lang('general.form.edit_record')"></i>
                                                @lang('general.form.edit_record')</a>

                                            <a href="{{ route('vehical.show', $row->id) }}"
                                                class="btn btn-sm bg-grey "><i
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

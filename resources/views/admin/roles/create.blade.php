@extends('layouts.app')

@section('title', __('rolesLng.form_title'))

@section('toolbar')
    <div class="toolbar">
        <div class="row col-12 col-sm-12 col-md-12">
            <div class="col-12 col-sm-5 col-md-6">
                <h6 class="text-muted">@lang('general.nav.user_managment') / @lang('rolesLng.form_title') / @lang('general.common.create')</h6>
            </div>
            <div class="col-12 col-sm-7 col-md-6 text-right">
                <div class="btn-toolbar justify-content-end text-right" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group">
                        <a id="back-btn" href="{{ route('admin.roles.index') }}"
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
                        <form method="post" action="{{ route('admin.roles.store') }}" name="addForm" id="addForm"
                            data-parsley-validate class="form-horizontal form-label-left">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    @include('admin.roles.body')
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

            //Select All checkbox click
            $('body').on('change', 'input[name="selectAll"]', function(e) {
                $('input:checkbox').prop('checked', this.checked);
            });
        });
    </script>
@endpush
{{-- <x-admin-layout>

    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Role Index</a>
                </div>
                <div class="flex flex-col">
                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                        <form method="POST" action="{{ route('admin.roles.store') }}">
                            @csrf
                          <div class="sm:col-span-6">
                            <label for="name" class="block text-sm font-medium text-gray-700"> Role name </label>
                            <div class="mt-1">
                              <input type="text" id="name" name="name" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                            @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                          </div>
                          <div class="sm:col-span-6 pt-5">
                            <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Create</button>
                          </div>
                        </form>
                      </div>

                </div>

            </div>
        </div>
    </div>
</x-admin-layout> --}}

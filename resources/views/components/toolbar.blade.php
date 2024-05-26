<div class="btn-group mr-2" role="group">
    <a id="home-link" href="/" class="btn btn-sm back-btn-color fixed-width-button-100">@lang('general.form.back_btn')</a>
</div>
<div class="btn-group mr-2" role="group">
    <button id="search-btn" class="btn btn-sm search-btn-color fixed-width-button-100">@lang('general.form.search_record')</button>
</div>
@if(isset($showExportButton) && $showExportButton)
    <div class="btn-group mr-2" role="group">
        <button id="export-btn" class="btn btn-sm export-btn-color fixed-width-button-100">@lang('general.form.export_btn')</button>
    </div>
@endif

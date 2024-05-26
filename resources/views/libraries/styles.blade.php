<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

<!-- Include DataTables CSS (adjust the path accordingly) -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">


<!-- Include Select2 CSS (update version to the latest stable) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #5A5A5A;
        outline: 0;
        box-shadow: 0 0 0 0.2rem #ccc;
    }

    .page-link {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #343a40;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }

    .page-item.active .page-link {
        z-index: 1;
        color: #646464;
        background-color: #9b9b9b77;
        border-color: #9b9b9b77;
    }

    .page-item.active .page-link:focus {
        border-color: #5A5A5A;
        outline: 0;
        box-shadow: 0 0 0 0.2rem #ccc;
    }

    .page-link:hover {
        z-index: 2;
        color: #B39354;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .table thead th {
        background-color: #3e515f;
        color: #ffffff;
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .create-btn-color {
        background-color: #616f4a;
        color: #ffffff;
    }

    .back-btn-color {
        background-color: #3a3a3a;
        color: #ffffff;
    }

    .search-btn-color {
        background-color: #afb579;
        color: #ffffff;
    }

    .export-btn-color {
        background-color: #062525;
        color: #ffffff;
    }

    .edit-btn-color {
        background-color: #3a7443;
        color: #ffffff;
    }

    .delete-btn-color {
        background-color: #b58e7982;
        color: #ffffff;
    }
</style>

@stack('css')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
</script>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
</script>

<!-- Include DataTables JS (adjust the path accordingly) -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Include DataTables Bootstrap 4 Integration (adjust the path accordingly) -->
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<!-- Include Select2 JS (update version to the latest stable) -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- Include Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    let subMenu = document.getElementById("subMenu");

    function toggleMenu() {
        subMenu.classList.toggle("open-menu");
    }

    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                "sProcessing": "Processing...",
                "sLengthMenu": "Display _MENU_ Items",
                "sZeroRecords": "No data.",
                "sInfo": "_TOTAL_ Displays from _START_ to _END_",
                "sInfoEmpty": "Displaying 0 to 0 of 0 results",
                "sInfoFiltered": "(Extracted from all _MAX_ items)",
                "sInfoPostFix": "",
                "sSearch": "Search :",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Head",
                    "sPrevious": "Previous",
                    "sNext": "Next",
                    "sLast": "Last"
                }
            }
        });
    });

    $(".js-example-basic-multiple").select2();
    $(".js-example-basic-single").select2();
</script>

@stack('js')

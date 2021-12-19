<!DOCTYPE html>

<html>

<head>

    <title>Laravel 8 Ajax CRUD tutorial using Datatable - Core Learners</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

</head>

<body>

    
    <x-header />
    

<div class="container">

    <h1>Laravel 8 Ajax CRUD tutorial using Datatable - Core Learners</h1>

    <a class="btn btn-success" href="javascript:void(0)" id="createNewCompany"> Create New Customer</a>

    <table id="myTableData" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="companyForm" name="companyForm" class="form-horizontal">
                   <input type="hidden" name="company_id" id="company_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="description" name="description" placeholder="Enter Email" value="" maxlength="50" required="">
                        </div>
                    </div>
                    
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

    

<script type="text/javascript">

  $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    // Show Data table
    var table = $('#myTableData').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('company.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]

    });
    // Show Modal Form
    $('#createNewCompany').click(function () {
        $('#saveBtn').val("create-company");
        $('#company_id').val('');
        $('#companyForm').trigger("reset");
        $('#modelHeading').html("Create New Company");
        $('#ajaxModel').modal('show');
    });
    // Store Data
    $('#saveBtn').click(function (e) {

        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
        data: $('#companyForm').serialize(),
        url: "{{ route('company.store') }}", //Different route
        type: "POST",
        dataType: 'json',

        success: function (data) {
            $('#companyForm').trigger("reset");
            $('#ajaxModel').modal('hide');
            table.draw();
        },

        error: function (data) {
            console.log('Error:', data);
            $('#saveBtn').html('Save Changes');
        }
        });

    });
    // Edit Code
    $('body').on('click', '#EditCompany', function () {

      var company_id = $(this).data('id');

      $.get("{{ route('company.index') }}" +'/' + company_id +'/edit', function (data) { //Changeable Url

          $('#modelHeading').html("Edit Company");
          $('#saveBtn').val("edit-company");
          $('#ajaxModel').modal('show');
          $('#company_id').val(data.id);
          $('#name').val(data.name);
          $('#description').val(data.description);
      })

   });

    $('body').on('click', '#deleteCompany', function () {
        var company_id = $(this).data("id");
        confirm("Are You sure want to delete !");
        $.ajax({
            type: "DELETE",
            url: "{{ route('company.store') }}"+'/'+company_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }

        });

    });

     

  });

</script>

</html>
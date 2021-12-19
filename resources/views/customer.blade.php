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

    <a class="btn btn-success" href="javascript:void(0)" id="createNewCustomer"> Create New Customer</a>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Religion</th>
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
                <form id="customerForm" name="customerForm" class="form-horizontal">
                   <input type="hidden" name="customer_id" id="customer_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="religion">Religion</label>
                        <select name="religion" id="religion" class="form-control">
                          <option value="Islam" selected>Islam</option>
                          <option value="Hindu">Hindu</option>
                          <option value="Cristan">Cristan</option>
                        </select>
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
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('customer.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'address', name: 'address'},
            {data: 'religion', name: 'religion'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]

    });
    // Show Modal Form
    $('#createNewCustomer').click(function () {
        $('#saveBtn').val("create-customer");
        $('#customer_id').val('');
        $('#customerForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });
    // Store Data
    $('#saveBtn').click(function (e) {

        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
        data: $('#customerForm').serialize(),
        url: "{{ route('customer.store') }}", //Different route
        type: "POST",
        dataType: 'json',

        success: function (data) {
            $('#customerForm').trigger("reset");
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
    $('body').on('click', '#EditCustomer', function () {

      var customer_id = $(this).data('id');

      $.get("{{ route('customer.index') }}" +'/' + customer_id +'/edit', function (data) { //Changeable Url

          $('#modelHeading').html("Edit Product");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#customer_id').val(data.id);
          $('#name').val(data.name);
          $('#email').val(data.email);
          $('#address').val(data.address);
          $('#religion').val(data.religion);

      })

   });

    $('body').on('click', '#deleteCustomer', function () {
        var customer_id = $(this).data("id");
        confirm("Are You sure want to delete !");
        $.ajax({
            type: "DELETE",
            url: "{{ route('customer.store') }}"+'/'+customer_id,
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
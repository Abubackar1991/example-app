@extends('layouts.master')

@section('title', 'Posts')

@section('sidebar')
    @@parent

    <p>This is appended to the master sidebar.</p>
@stop

    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> --}}
    {{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

@section('content')
        &nbsp; <h1>Users Post List</h1> &nbsp; &nbsp;
        <a class="btn btn-info" href="javascript:void(0)" id="createNewPost"> Add New Post</a>
        <table class="table table-striped data-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

            <div class="modal fade" id="ajaxModelexa" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modelHeading"></h4>
                        </div>
                        <div class="modal-body">
                            <form id="postForm" name="postForm" class="form-horizontal">
                            <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Name" value="" required>
                                    </div>
                                </div>
                                <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" id="savedata" value="create">Save Post
                                </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
@stop

<script type="text/javascript">
  $(function () {

     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('ajaxposts.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

     $('#createNewPost').click(function () {
        $('#savedata').val("create-post");
        $('#id').val('');
        $('#postForm').trigger("reset");
        $('#modelHeading').html("Create New Post");
        $('#ajaxModelexa').modal('show');
    });

    $('#savedata').click(function (e) {
        e.preventDefault();
       // $(this).html('Sending..');

        $.ajax({
          data: $('#postForm').serialize(),
          url: "{{ route('ajaxposts.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
              $('#postForm').trigger("reset");
              $('#ajaxModelexa').modal('hide');
              table.draw();
          },
          error: function (data) {
              $('#savedata').html('Save Changes');
          }
      });
    });

    $('body').on('click', '.editPost', function () {
      var id = $(this).data('id');
      $.get("{{ route('ajaxposts.index') }}" +'/' + id +'/edit', function (data) {
          $('#modelHeading').html("Edit Post");
          $('#savedata').val("edit-user");
          $('#ajaxModelexa').modal('show');
          $('#id').val(data.id);
          $('#title').val(data.title);
      })
   });

   $('body').on('click', '.deletePost', function () {
        var id = $(this).data("id");
        confirm("Are You sure want to delete this Post!");
        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxposts.store') }}"+'/'+id,
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

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
          ajax: "{{ route('users.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
      $('#createNewUser').click(function () {
          $('#saveBtn').val("create-user");
          $('#user_id').val('');
          $('#userForm').trigger("reset");
          $('#modelHeading').html("Create New User");
          $('#ajaxModel').modal('show');
      });
      $('body').on('click', '.editUser', function () {
        var user_id = $(this).data('id');
        $.get("{{ route('users.index') }}" +'/' + user_id +'/edit', function (data) {
            $('#modelHeading').html("Edit User");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#password').val(data.password);
        })
     });
      $('#saveBtn').click(function (e) {
          e.preventDefault();
          $(this).html('Save');
          $.ajax({
            data: $('#userForm').serialize(),
            url: "{{ route('users.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
              console.log('Success:', data);
              alert(Object.values(data));
                $('#bookForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
                //alert("Erro: "+ Object.values(data));
                $('#saveBtn').html('Save Changes');
            }
        });
      });
      $('body').on('click', '.deleteUser', function () {
          var user_id = $(this).data("id");
          $confirm = confirm("Are You sure want to delete !");
          if($confirm == true ){
              $.ajax({
                  type: "DELETE",
                  url: "{{ route('users.store') }}"+'/'+user_id,
                  success: function (data) {
                      table.draw();
                      alert(Object.values(data));
                  },
                  error: function (data) {
                      console.log('Error:', data);
                  }
              });
          }
      });
    });
  </script>
@extends ('layout.app')
@section ('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 text-gray-800">Daftar Pengguna</h1>
</div>

<a href="javascript:void(0)" id="add-button" class="btn btn-primary my-3">Tambah Pengguna</a>
<table class="table table-striped table-bordered display" id="user_table">
  <thead class="table-dark" defer>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">NIM/NID</th>
      <th scope="col">Role</th>
      <th scope="col">Email</th>
      <th scope="col">Nomor Handphone</th>
      <th scope="col">Organisasi</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
    <tbody>
    </tbody>
  </table>

  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"
        integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"
        integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>
  
        <script>
          //csrf token
          $(function() {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
          
          //datatable
          $('#user_table').DataTable({
              processing: true, 
              serverside: true,
              ajax: {
                      url: "{{route('user.index')}}",
                      type: 'GET'
                  },
              columns: [
                  { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  { data: 'name', name: 'name' },
                  { data: 'nim', name: 'nim' },
                  { data: 'role', name: 'role' },
                  { data: 'email', name: 'email' },
                  { data: 'phonenumber', name: 'phonenumber' },
                  { data: 'organization', name: 'organization' },
                  { data: 'action', name: 'action'},
                      ]
                  });
      
          //modal show +add/edit
            if ($("#modal-create-edit").length > 0) {
                $("#modal-create-edit").validate({
                    submitHandler: function (form) {
                    var actionType = $('#save-button').val();
                    $('#save-button').html('Kirim..');
            $.ajax({
                data    : $('#create-edit-form').serialize(), 
                url     : "{{ route('user.store') }}",
                type    : "POST",
                dataType: 'json', 
                success: function (data) { 
                    $('#create-edit-form').trigger("reset"); 
                    $('#modal-create-edit').modal('hide'); 
                    $('#save-button').html('Simpan');  
                    iziToast.success({ 
                        title: 'Data Berhasil Disimpan',
                        message: '{{ Session('
                        success ')}}',
                        position: 'bottomRight'
                    });
                },
                error: function (data) { //jika error tampilkan error pada console
                    console.log('Error:', data);
                    $('#save-button').html('Simpan');
                }
            });
        }
    })
}
      
          $('body').on('click', '.editUser', function () {
              var data_id = $(this).data('id');
              $.get('user/' + data_id + '/edit', function (data) {
                  $('#modal-title ').html("Edit Pengguna"); 
                  $('#save-button').val("edit-user");
                  $('#modal-create-edit').modal('show');
                  //set value
                  $('#id').val(data.id);              
                  $('#name').val(data.name);
                  $('#nim').val(data.nim);
                  $('#role').val(data.role);
                  $('#email').val(data.email);
                  $('#password').val(data.password);
                  $('#phonenumber').val(data.phonenumber);
                  $('#organization').val(data.organization);
                  })
              });

          //delete modal show
          $('body').on('click', '.deleteUser', function () {
              dataId = $(this).data('id');
              $('#confirmation-modal').modal('show');
              });
              
          $('#delete-button').click(function () {
              $.ajax({
                  url: "user/" + dataId, 
                  type: 'delete',
                  beforeSend: function () {
                      $('#delete-button').text('Hapus Data');
                  },
                  success: function (data) { 
                      setTimeout(function () {
                          $('#confirmation-modal').modal('hide'); 
                          });
                      }
                  });
              });
        });
  </script>
  @endsection
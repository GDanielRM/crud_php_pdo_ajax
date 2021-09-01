<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRUD CON PHP, PDO, AJAX y DataTables.js</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">

    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <div class="container background">
        <h1 class="text-center">CRUD CON PHP, PDO, AJAX y DataTables.js</h1>
        <h1 class="text-center">GIT DANIEL</h1>

        <div class="row">
            <div class="col-2 offset-10">
                <div class="text-center">

                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalUser" id="buttonCreate">
                        <i class="bi| bi-plus-circle-fill"></i>
                        Create
                    </button>

                </div>
            </div>
        </div>
        <br><br>

        <div class="table-responsive">
            <table id="users_dates" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>APELLIDOS</th>
                        <th>TELEFONO</th>
                        <th>EMAIL</th>
                        <th>IMAGEN</th>
                        <th>FECHA CREACION</th>
                        <th>EDITAR</th>
                        <th>BORRAR</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form method="POST" id="form" enctype="multipart/form-data">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <label for="name">Ingrese el Nombre</label>
                                <input type="text" name="name" id="name" class="form-control"><br>

                                <label for="last_names">Ingrese los Apellidos</label>
                                <input type="text" name="last_names" id="last_names" class="form-control"><br>

                                <label for="phone">Ingrese el Telefono</label>
                                <input type="text" name="phone" id="phone" class="form-control"><br>

                                <label for="email">Ingrese el Email</label>
                                <input type="text" name="email" id="email" class="form-control"><br>

                                <label for="image">Ingrese la Imagen</label>
                                <input type="file" name="user_image" id="user_image" class="form-control">
                                <span id="uploaded_image"></span><br>
                            </div>

                            <div class="modal-footer">
                                <input type="hidden" name="id_user" id="id_user" value="create">
                                <input type="hidden" name="operation" id="operation" value="create">
                                <input type="submit" name="action" id="action" class="btn btn-success" value="create">
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('buttonCreate').click(function() {
                $('#form')[0].reset();
                $('.modal-tittle').text('Crear Usuario');
                $('#action').val('create');
                $('#operation').val('create');
                $('#uploaded_image').html("");
            });

            var dataTable = $('#users_dates').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "get_registers.php",
                    type: "POST"
                },
                "columnsDefs": [{
                    "targets": [0, 3, 4],
                    "orderable": false,
                }],
                "language": {
                    "decimal": "",
                    "emptyTable": "No hay registros",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });

            $(document).on('submit', '#form', function(event) {
                event.preventDefault();

                var name = $('#name').val();
                var lastNames = $('#last_names').val();
                var phone = $('#phone').val();
                var email = $('#email').val();
                var extencion = $('#user_image').val().split('.').pop().toLowerCase();

                if (extencion != '') {
                    if ($.inArray(extencion, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                        alert('Formato de imagen no valido');
                        $('#user_image').val('');
                        return false;
                    }
                }

                if (name != '' && lastNames != '' && email != '') {
                    $.ajax({
                        url: "create.php",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            alert(data);
                            $('#form')[0].reset();
                            $('#modalUser').modal.hidde();
                            dataTable.ajax.reload();

                        }
                    });
                } else {
                    alert('Algunos campos son obligatorios');
                }
            });

            $(document).on('click', '.edit', function() {
                var id_user = $(this).attr('id');

                $.ajax({
                    url: "get_register.php",
                    method: "POST",
                    data: {
                        id_user: id_user
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#modalUser').modal('show');
                        $('#name').val(data.name);
                        $('#last_names').val(data.lastNames);
                        $('#phone').val(data.phone);
                        $('#email').val(data.email);
                        $('.modal-tittle').text('Ediar Usuario');
                        $('#id_user').val(id_user);
                        $('#uploaded_image').html(data.userImage);
                        $('#action').val('edit');
                        $('#operation').val('edit');
                    },
                    error: function(jqXHR, textStatus, errorthrown) {
                        console.log(jqXHR, errorthrown);
                    }
                });
            });

            $(document).on('click', '.delete', function() {
                var id_user = $(this).attr('id');

                if (confirm('¿Está seguro de borrar este registro? (' + id_user + ')')) {
                    $.ajax({
                        url: "delete.php",
                        method: "POST",
                        data: {
                            id_user: id_user
                        },
                        dataType: 'json',
                        success: function(data) {
                            alert(data);
                            dataTable.ajax.reload();
                        },
                        error: function(jqXHR, textStatus, errorthrown) {
                            console.log(jqXHR, errorthrown);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
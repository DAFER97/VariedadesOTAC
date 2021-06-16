$(document).ready(function() {


    let permiso_insercion = $('#permisos').data('insercion');
    let permiso_eliminacion = $('#permisos').data('eliminacion');
    let permiso_actualizacion = $('#permisos').data('actualizacion');

    var idioma_espanol = {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior",
        },
        oAria: {
            sSortAscending: ": Activar para ordenar la columna de manera ascendente",
            sSortDescending: ": Activar para ordenar la columna de manera descendente",
        },
        buttons: {
            copy: "Copiar",
            colvis: "Visibilidad",
        },
    };

    tabla = $("#tabla").DataTable({
        ajax: {
            method: "POST",
            url: "http://localhost/variedades-OTAC/ajaxPermisos/getPermisos",
        },
        //   ==============CONTENIDO DEL DATATABLE================================
        columns: [{

                data: "id_permiso"
            },
            {

                data: "rol",
            },
            {
                data: "objeto",
            },
            {
                data: "permiso_insercion",
                orderable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    if (data == 1) {
                        return '<span class="badge badge-success p-2">' + data + '</span>'
                    } else {
                        return '<span class="badge badge-danger p-2">' + data + '</span>'
                    }
                }
            },
            {
                data: "permiso_eliminacion",
                orderable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    if (data == 1) {
                        return '<span class="badge badge-success p-2">' + data + '</span>'
                    } else {
                        return '<span class="badge badge-danger p-2">' + data + '</span>'
                    }
                }
            },
            {
                data: "permiso_actualizacion",
                orderable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    if (data == 1) {
                        return '<span class="badge badge-success text-center p-2">' + data + '</span>'
                    } else {
                        return '<span class="badge badge-danger text-center p-2">' + data + '</span>'
                    }
                }
            },
            {
                data: "permiso_consultar",
                orderable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    if (data == 1) {
                        return '<span class="badge badge-success p-2">' + data + '</span>'
                    } else {
                        return '<span class="badge badge-danger p-2">' + data + '</span>'
                    }
                }
            },
            {

                data: "creado",
            },
            {

                data: "fech_crea",
            },
            {

                data: "modificado",
            },
            {
                data: "fech_mod",
            },
            {
                "render": function() {

                    if (permiso_eliminacion == 1 && permiso_actualizacion == 1) {
                        return `<div class="text-center"><a  class="btn btn-primary mr-2" id="btnEditar"><i class="fas fa-edit" ></i></a><a class="btn btn-danger mr-2" id="btnBorrar"><i class="fas fa-trash-alt"></i></a></div>`;
                    } else if (permiso_eliminacion == 1 && permiso_actualizacion == 0) {
                        return ` <div class="text-center"> <a class="btn btn-danger mr-2" id="btnBorrar"><i class="fas fa-trash-alt"></i></a></div>`;
                    } else if (permiso_eliminacion == 0 && permiso_actualizacion == 1) {
                        return `<div class="text-center"><a  class="btn btn-primary mr-2" id="btnEditar"><i class="fas fa-edit" ></i></a></div>`;
                    } else if (permiso_eliminacion == 0 && permiso_actualizacion == 0) {
                        return `<span class="badge badge-danger p-2">No tienes permisos</span>`
                    }
                },
            },
        ],
        responsive: true,
        autoWidth: false,

        language: idioma_espanol,

    });



    var btn1 = `<button class="btn btn-secondary btn-warning mr-2" id="btnNuevo" data-toggle="modal" tabindex="0" aria-controls="tabla" type="button" data-target="#insertar" title="Agregar Permiso"><span><i class="nav-icon fas fa-exclamation-circle nav-icon" >Insertar Permiso</i></span></button>`;


    if (permiso_insercion) {
        $(".dataTables_length").append(btn1);
    }




    //   ==============INSERTAR Y EDITAR========================================
    var editar = function(tbody, table) {

        $(document).on("click", "#btnEditar", function() {


            editar = true;

            //quitar el selected
            $("#rol").prop('disabled', true);
            $("#objeto").prop('disabled', true);
            $("#rol option:selected").removeAttr('selected');
            $("#objeto option:selected").removeAttr('selected');


            console.log(editar);
            $('#titulo').empty();
            $('#btnGuardar').empty();
            $('#titulo').append('EDITAR PERMISO');
            $('#btnGuardar').append('Editar')
            $("#form").trigger("reset");


            //desde aqui lo nuevo
            $("#agregar").prop('checked', false);
            $("#eliminar").prop('checked', false);
            $("#actualizar").prop('checked', false);
            $('#mostrar').prop('checked', false);

            //quitar el selected

            $("#rol option:selected").removeAttr('selected');
            $("#objeto option:selected").removeAttr('selected');

            if (table.row(this).child.isShown()) {
                var data = table.row(this).data();
            } else {
                var data = table.row($(this).parents("tr")).data();
            }

            $("#rol option[value='" + data['roll'] + "']").attr("selected", true);
            $("#objeto option[value='" + data['obj'] + "']").attr("selected", true);

            $("#id").val(data['id_permiso']);

            if (data['permiso_insercion'] == '1') {
                $("#agregar").prop('checked', true);
            }
            if (data['permiso_eliminacion'] == '1') {
                $("#eliminar").prop('checked', true);
            }
            if (data['permiso_actualizacion'] == '1') {
                $("#actualizar").prop('checked', true);
            }
            if (data['permiso_consultar'] == '1') {
                $('#mostrar').prop('checked', true);
            }

            $("#modalCRUD").modal("show");
        });
    }

    editar("#tabla tbody", tabla);


    $(document).on("click", "#btnNuevo", function() {

        editar = false;
        console.log(editar);
        //quitar el selected
        $("#rol").prop('enabled', true);
        $("#objeto").prop('enabled', true);
        $("#rol option:selected").removeAttr('selected');
        $("#objeto option:selected").removeAttr('selected');

        $('#titulo').empty();
        $('#btnGuardar').empty();
        $('#titulo').append('AGREGAR PERMISO');
        $('#btnGuardar').append('Agregar');
        $("#modalerror").remove();
        $('#form').trigger('reset');
        $("#modalCRUD").modal("show");
    });


    $("#form").submit(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        let url;
        if (editar) {
            url = "http://localhost/variedades-OTAC/ajaxPermisos/updPermisos";
        } else {
            url = "http://localhost/variedades-OTAC/ajaxPermisos/InsPermisos";
        }
        console.log(url);

        let formulario = $(this);
        let dataSerializada = formulario.serialize();
        console.log(dataSerializada);

        $.ajax({
                type: "POST",
                url: url,
                typeData: "json",
                data: dataSerializada,
            })
            .done(function(response) {
                console.log(response);

                console.log(response.error);

                var mensaje = "";


                if (response.error) {
                    Notiflix.Notify.Failure(`${response.mensaje}`);
                } else {

                    Notiflix.Notify.Success(`${response.mensaje}`);
                    tabla.ajax.reload(null, false);
                    $("#modalCRUD").modal("hide");
                }

            })
            .fail(function(jqXHR, textStatus, error) {
                alert('sdasd');
            });
    });

    $('#btnGuardar').click(function() {
        $('#form').submit();
    });

    //eliminar
    var eliminar = function(tbody, table) {
        $(document).on("click", "#btnBorrar", function() {
            fila = $(this);
            if (table.row(this).child.isShown()) {
                var data = table.row(this).data();
            } else {
                var data = table.row($(this).parents("tr")).data();
            }

            id = data['id_permiso'];


            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger",
                },
                buttonsStyling: false,
            });

            swalWithBootstrapButtons
                .fire({
                    title: "¿Estas seguro?",
                    text: "De querer borrar a la pregunta ",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, borrar!",
                    cancelButtonText: "No, cancelar!",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.value) {
                        borrar_registro(id, function(data) {
                            console.log(data);
                            if (data.error) {
                                swalWithBootstrapButtons.fire(
                                    "Upsss!",
                                    "Ocurrio un error al querer borrarla",
                                    "error"
                                );
                            } else {
                                //aqui borramos   
                                table.row(fila.parents("tr")).remove().draw();
                                swalWithBootstrapButtons.fire(
                                    "Borrada!",
                                    "tu fila ha sido borrada",
                                    "success"
                                );
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        Notiflix.Loading.Remove();
                        swalWithBootstrapButtons.fire(
                            "Cancelada",
                            "Tu fila esta ha salvo :)",
                            "error"
                        );
                    }
                });
        });
    }

    eliminar("#tabla tbody", tabla);
    //eliminar

    function borrar_registro(id, callback) {
        $.ajax({
                type: "POST",
                url: "http://localhost/variedades-OTAC/ajaxPermisos/eliPermiso&id=" + id,
                dataType: "json",
            })
            .done(function(data) {
                callback(data);
            })
            .fail(function(jqXHR, textStatus, error) {
                console.log("Post error: " + error);
            });
    }

});
$(document).ready(function() {


    // PERMISOS
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
            url: "http://localhost/variedades-OTAC/ajaxObjetos/getObjetos",
        },
        //   ==============CONTENIDO DEL DATATABLE================================
        columns: [{
                title: "Codigo",
                data: "id_objeto",
            },
            {
                title: "Objeto",
                data: "objeto",
            },
            {
                title: "Descripcion",
                data: "descripcion",
            },
            {
                title: "Tipo objeto",
                data: "tipo_objeto",
            },
            {
                title: "id padre",
                data: "idPadre",
            },
            {
                title: "icono",
                data: "icono",
            },
            {
                title: "url",
                data: "url",
            },

            {
                title: "creado por",
                data: "creado_por",
            },

            {
                title: "estado",
                data: "estado",
            },
            {
                title: "fecha creacion",
                data: "fecha_creacion",
            },
            {
                title: "modificado por ",
                data: "modificado_por",
            },
            {
                title: "fecha modificacion",
                data: "fecha_modificacion",
            },
            {
                title: "Acciones",
                "render": function() {

                    if (permiso_eliminacion == 1 && permiso_actualizacion == 1) {
                        return `<div class="text-center"><a  class="btn btn-primary mr-2" id="btnEditar"><i class="fas fa-edit" ></i></a><a class="btn btn-danger mr-2" id="btnBorrar"><i class="fas fa-trash-alt"></i></a></div>`;
                    } else if (permiso_eliminacion == 1 && permiso_actualizacion == 0) {
                        return ` <div class="text-center"> <a class="btn btn-danger mr-2" id="btnBorrar"><i class="fas fa-trash-alt"></i></a></div>`;
                    } else if (permiso_eliminacion == 0 && permiso_actualizacion == 1) {
                        return `<div class="text-center"><a  class="btn btn-primary mr-2" id="btnEditar"><i class="fas fa-edit" ></i></a></div>`;
                    } else if (permiso_eliminacion == 0 && permiso_actualizacion == 0) {
                        return `<span class="badge badge-danger p-2">No tienes permisos</span>`;
                    }
                },
            },
        ],
        responsive: true,
        autoWidth: true,
        language: idioma_espanol,



    });

    // if (permiso_insercion) {

    var btn1 = `<button class="btn btn-primary btn-warning mr-2" id="btnNuevo" data-toggle="modal" tabindex="0" aria-controls="tabla" type="button" data-target="#insertar" title="Agregar Nuevo Rol"><span><i class="fas fa-user-shield"> Insertar Menu</i></span></button>`;

    // }

    if (permiso_insercion) {
        $(".dataTables_length").append(btn1);
    }


    //   ==============INSERTAR Y EDITAR========================================
    var editar = function(tbody, table) {
        //   =====================EDITAR==========================================
        $(tbody).on("click", "#btnEditar", function() {

            // Limpiar los Select
            $("#menupadre option:selected").removeAttr('selected');
            $("#estado option:selected").removeAttr('selected');

            editar = true;
            $("#titulo").empty();
            $("#btnGuardar").empty();
            $("#titulo").append("EDITAR OBJETOS");
            $("#btnGuardar").append("Editar");
            $("#form").trigger("reset");

            if (table.row(this).child.isShown()) {
                var data = table.row(this).data();
            } else {
                var data = table.row($(this).parents("tr")).data();
            }
            //   =====================TRAE LOS DATOS AL MODAL==========================

            //   =====================TRAE LOS DATOS AL MODAL==========================
            $("#id").val(data["id_objeto"]);
            $("#menu").val(data["objeto"]);
            $("#descripcion").val(data["descripcion"]);
            $("#tipo_objeto").val(data["tipo_objeto"]);
            $("#icono").val(data["icono"]);
            $("#url").val(data["url"]);
            $("#estado option[value='" + data["estado"] + "']").attr("selected", true);
            $("#menupadre option[value='" + data["idPadre"] + "']").attr("selected", true);
            $("#fec_registro").val(data["fecha_creacion"]);
            $("#modalCRUD").modal("show");
        });
    };

    editar("#tabla tbody", tabla);

    //   =====================INSERTAR==========================================
    $(document).on("click", "#btnNuevo", function() {

        // Limpiar los Select
        $("#menupadre option:selected").removeAttr('selected');
        $("#estado option:selected").removeAttr('selected');
        editar = false
        $('#titulo').empty();
        $('#btnGuardar').empty();
        $('#titulo').append('AGREGAR OBJETO');
        $('#btnGuardar').append('Agregar');
        $("#modalerror").remove();
        $('#form').trigger('reset');
        $("#modalCRUD").modal("show");
    });


    $("#form").submit(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        Notiflix.Loading.Standard('Cargando...');
        let url;
        // =====================SE VALIDA PARA SABER QUE FUNCION VA A REALIZAR===================================
        if (editar) {
            url = "http://localhost/variedades-OTAC/ajaxObjetos/updObjetos";
        } else {
            url = "http://localhost/variedades-OTAC/ajaxObjetos/insObjetos";
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
                Notiflix.Loading.Remove();
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
                Notiflix.Loading.Remove();
                console.log(jqXHR, textStatus, error);
            });
    });

    $('#btnGuardar').click(function() {
        $('#form').submit();
    });

    // ===========================ELIMINAR=======================================================

    var eliminar = function(tbody, table) {
        $(document).on("click", "#btnBorrar", function() {


            fila = $(this);


            if (table.row(this).child.isShown()) {
                var data = table.row(this).data();
            } else {
                var data = table.row($(this).parents("tr")).data();
            }


            id = data['id_objeto'];


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
                    text: "De querer borrar un objeto",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, borrar!",
                    cancelButtonText: "No, cancelar!",
                    reverseButtons: true,
                })
                .then((result) => {
                    Notiflix.Loading.Standard('Cargando...');
                    if (result.value) {
                        borrar_registro(id, function(data) {
                            Notiflix.Loading.Remove();
                            if (data.error) {
                                swalWithBootstrapButtons.fire(
                                    "Upsss!",
                                    "Ocurrio un error al querer borrarlo",
                                    "error"
                                );
                            } else {
                                //aqui borramos
                                tabla.row(fila.parents("tr")).remove().draw();
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
                url: "http://localhost/variedades-OTAC/ajaxObjetos/delObjetos&id=" + id, // el id es necesario ya que nosotros se lo mandamos a php para borrar el registro de la solicitud
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
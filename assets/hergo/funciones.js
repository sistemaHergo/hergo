$(document).ready(function()
{
   /*  $(".tablahergo").DataTable({
         "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "responsive": true,
    });*/
})
   
function base_url(complemento)
{
     complemento = (complemento) ? complemento : '';
    var baseurl=$('#baseurl').val();
    return baseurl+complemento;
}
/******************AJAX************************/
/**********************************************/
function retornarajax(url,datos,callback)
    {
        var retornar=new Object();
        $("#cargando").css("display","block")
        
        return $.ajax({
                type:"POST",
                url: url,
                dataType: "json",
                data: datos,
               // processData: false, //UP
              //  contentType: false  //UP
            }).done(function(data){
                var retornar=new Object();      
                datos_retornados="retorno";
                retornar.estado="ok";
                retornar.respuesta=data;
                $("#cargando").css("display","none")        
                if(callback)
                    callback(retornar);
                
                
            }).fail(function( jqxhr, textStatus, error ) {
                var retornar=new Object();      
                var err = textStatus + ", " + error;
                console.log( "Request Failed: " + err );
                if(jqxhr.status===0)
                {
                    errorajax="No existe conexion, veirique su red";
                }
                else if(jqxhr.status==404)
                {
                    errorajax="No se encontro la pagina [404]";
                }
                else if(jqxhr.status==500)
                {
                    errorajax="Error interno del servidor [500]";
                }
                else if (textStatus==='parsererror')
                {
                    errorajax="Requested JSON parse failed, error de sintaxis en retorno json ";
                }
                else if(textStatus==='timeout')
                {
                    errorajax="Error de tiempo de espera";
                }
                else if(textStatus==='abort')
                {
                    errorajax="Solicitud de ajax abortada";
                }
                else
                {
                    errorajax="error desconocido "+ jqxhr.responseText;
                }
                retornar.estado="error";
                retornar.respuesta=errorajax;
                
                if(callback)
                    callback(retornar);
                
            });
    }
    function validarresultado_ajax(resultado)
    {
        if(resultado.estado=="ok")
        {
            return true;
        }
        else
        {
            $(".mensaje_error").html(resultado.respuesta);
            $("#modal_error").modal("show");
            setTimeout(function(){$("#modal_error").modal("hide");},5000)
            return false;
        }
    }

/**********************************************************/
/**********************************************************/
function resetForm(id)
{
    $(id)[0].reset();
    $(id).bootstrapValidator('resetForm', true);
}
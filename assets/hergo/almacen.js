$(document).ready(function(){
  
     $('#form_almacen').bootstrapValidator({
             
        feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
        },
        excluded: ':disabled',
        fields: {          
           almacen: {
                validators: {
                        stringLength: {
                        min: 5,
                        message: 'Ingrese nombre de almacen válido'
                        
                    },
                    notEmpty: {
                        message: 'Campo obligatorio'
                    }
                        
                }
            },
            ciudad: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione ciudad'
                    }
                        
                }
            },

               
           }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            // Get the form instance
            var valuesToSubmit = $("#form_almacen").serialize();
            //console.log(valuesToSubmit)
            $.ajax({
                url: base_url("index.php/Almacen/agregarAlmacen"),
                data: valuesToSubmit,              
                type: 'POST',
            })
            .done(function( data, textStatus, jqXHR ) {
                if ( console && console.log ) {
                    console.log( "La solicitud se ha completado correctamente." );  
                    $('#contact-form-success').show().fadeOut(10000);
                    $('#modalalmacen').modal('hide');
                    document.location.href=""
                }
             })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( "La solicitud a fallado: " +  textStatus);
                }
            });
        });
});/**FIN READY**/
/********MODAL ALMACEN EDITAR**********/
$(document).on("click",".botoneditar",function(){
    $("#form_almacen")[0].reset();
    enivardatosmodalalmacen(this)
})
$(document).on("click",".btnnuevo",function(){
     $("#form_almacen")[0].reset();

})
function borrarmodal()
{
    $(".modalalmacentitulo").html("Agregar almacen")
    $("#modalnombrealmacen").val("")
    $("#modaldireccionalmacen").val("")
    $("#modalciudadalmacen").val("")
    $("#bguardar_almacen").html("Guardar")
}
function enivardatosmodalalmacen(id)
{
    fila=$(id).parents("tr")
    cod=$(fila).attr("id");
    datos=$(fila).find("td")
    almacen=$(datos[0]).html();
    sucursal = $(datos[1]).html()
    direccion=$(datos[2]).html();
    ciudad=$(datos[3]).html();
    telefonos = $(datos[4]).html();
    $("#cod_almacen").val(cod)
    $(".modalalmacentitulo").html("Editar Almacen")
    $("#modalnombrealmacen").val(almacen)
    $("#modalSucursal").val(sucursal)
    $("#modalDireccion").val(direccion)
    $("#modalciudadalmacen").val(ciudad)
    $("#modalTelefonos").val(telefonos)
    $("#bguardar_almacen").html("Editar")
    $('#modalalmacen').modal('show');
}


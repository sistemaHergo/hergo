var iniciofecha=moment().subtract(0, 'year').startOf('year')
var finfecha=moment().subtract(0, 'year').endOf('year')

$(document).ready(function(){ 
    
     $(".tiponumerico").inputmask({
        alias:"decimal",
        digits:2,
        groupSeparator: ',',
        autoGroup: true,
        autoUnmask:true
    });

    var start = moment().subtract(0, 'year').startOf('year')
    var end = moment().subtract(0, 'year').endOf('year')

 
    $(function() {
        moment.locale('es');
        function cb(start, end) {
            $('#fechapersonalizada span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
            iniciofecha=start
            finfecha=end
        }
        
        $('#fechapersonalizada').daterangepicker({

            locale: {
                  format: 'DD/MM/YYYY',
                  applyLabel: 'Aplicar',
                  cancelLabel: 'Cancelar',
                  customRangeLabel: 'Personalizado',
                },
            startDate: start,
            endDate: end,
            ranges: {
               'Gestion Actual': [moment().subtract(0, 'year').startOf('year'), moment().subtract(0, 'year').endOf('year')],
               "Hace un Año": [moment().subtract(1, 'year').startOf('year'),moment().subtract(1, 'year').endOf('year')],
               'Hace dos Años': [moment().subtract(2, 'year').startOf('year'),moment().subtract(2, 'year').endOf('year')],
               'Hace tres Años': [moment().subtract(3, 'year').startOf('year'),moment().subtract(3, 'year').endOf('year')],               
            }
        }, cb);

        cb(start, end);

    });
    $('#fechapersonalizada').on('apply.daterangepicker', function(ev, picker) {
      retornarTablaFacturacion();
    });
})
$(document).on("change","#almacen_filtro",function(){
    retornarTablaFacturacion();
})
$(document).on("change","#tipo_filtro",function(){
    retornarTablaFacturacion();
})
$(document).on("click", "#refresh", function () {
    retornarTablaFacturacion();
})


function retornarTablaFacturacion()
{
     agregarcargando();
    ini=iniciofecha.format('YYYY-MM-DD')
    fin=finfecha.format('YYYY-MM-DD')
    alm=$("#almacen_filtro").val()
    tipo=$("#tipo_filtro").val()
    //console.log({ini:ini,fin:fin,alm:alm,tipo:tipo})
    $.ajax({
        type:"POST",
        url: base_url('index.php/Facturas/MostrarTablaConsultaFacturacion'),
        dataType: "json",
        data: {ini:ini,fin:fin,alm:alm,tipo:tipo},
    }).done(function(res){
         quitarcargando();
      //   console.log(res);
        datosselect= restornardatosSelect(res)

        $("#facturasConsulta").bootstrapTable('destroy');
        $('#facturasConsulta').bootstrapTable({
                   
            data:res,
            striped:true,
            pagination:true,
            pageSize:"25",    
            search:true,        
            stickyHeader: true,
            stickyHeaderOffsetY: '50px',
            filter:true,
            showColumns:true,
            strictSearch: true,
            showToggle:true,


            columns: [            
            {
                field: 'lote',                
                title: 'lote',                            
                visible:false,
                searchable: false,
            },
            {
                field: 'manual',                
                title: 'Tipo',                            
                visible:true,
                align: 'center',
                formatter: tipoDosificacion
            },

            
            {
                field:'nFactura',
                title:"N° Fac",
                sortable:true,
                align: 'center',
                
               
            },
            {
                field:'fechaFac',
                title:"Fecha",
                align:'center',
                sortable:true,
                formatter: formato_fecha_corta,
                searchable: false,
            },
            {
                field:'ClienteNit',
                title:"N° Cliente",                
                sortable:true,
                visible:false,
                searchable: false,
            },
            {
                field:'ClienteFactura',
                title:"Cliente",                
                sortable:true,
                 filter: {
                    type: "select",
                    data: datosselect[0]
                }
            },
            {
                field:'sigla',
                title:"Movimiento",
                align: 'center',
                searchable: false,
                formatter: tipoNumeroMovimiento
                
            },
            {
                field:'total',
                title:"Total",                
                sortable:true,
                align: 'right',
                searchable: false,
                width:'100px',
                formatter:operateFormatter3,
                filter: { type: "input" },
            },
            {
                field:'vendedor',
                title:"Vendedor",
                sortable:true,
                align: 'center',
                filter: {
                    type: "select",
                    data: datosselect[1]
                }
            },
            {
                field:'fecha',
                title:"Fecha",
                align:'center',
                sortable:true,
                visible:false,
                searchable: false,
            },
            {
                field:'pagada',
                title:"Pagado",
                sortable:true,
                align: 'center',
                searchable: false,
                formatter: formatoFacturaPagada,
            
            },           
            {
                title: 'Acciones',
                align: 'center',
                width: '10%',
                width:'150px',
                searchable: false,
                events: eventosBotones,                
                formatter: formatoBotones
            }]
            
        });
    }).fail(function( jqxhr, textStatus, error ) {
    var err = textStatus + ", " + error;
    console.log( "Request Failed: " + err );
    });
}

function restornardatosSelect(res)
{
    var cliente = new Array()
    let vendedor = new Array()
    var datos =new Array()
    $.each(res, function(index, value){

        cliente.push(value.ClienteFactura)
        vendedor.push(value.vendedor)
    })
    cliente.sort();
    datos.push(cliente.unique());
    datos.push(vendedor.unique());
    return(datos);
}
Array.prototype.unique=function(a){
  return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
});

function operateFormatter3(value, row, index)
    {       
        num=Math.round(value * 100) / 100
        num=num.toFixed(2);
        return (formatNumber.new(num));
    }

Array.prototype.unique=function(a){
  return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
});

function tipoDosificacion(value, row, index) {
    $ret = ''
    if (row.manual == 1) {
        $ret = '<div style="font-size:1.5em;"><span class="fas fa-edit manual"></span></div>';
    } else {
        $ret = '<div style="font-size:1.5em; color:Tomato"><span class="fas fa-laptop computarizada"></span></div>';
        
    }
    return ($ret);
}
function tipoNumeroMovimiento(value, row, index) {
    $ret = row.sigla + "-" + row.movimientos;
    return ($ret);
}

function formatoBotones(value, row, index)
{
    if(row.anulada==1)
    {
        return [
        '<button type="button" class="btn btn-default verFactura"  aria-label="Right Align">',
        '<span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>',
        '<button type="button" class="btn btn-default "  disabled aria-label="Right Align">',
        '<span class="fa fa-times " aria-hidden="true"></span></button>',
        '<button type="button" class="btn btn-default printFactura" aria-label="Right Align">',
        '<span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>'
        ].join('');    
    }
    else
    {
        return [
        '<button type="button" class="btn btn-default verFactura"  aria-label="Right Align">',
        '<span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>',        
        '<button type="button" class="btn btn-default anularFactura"  aria-label="Right Align">',
        '<span class="fa fa-times " aria-hidden="true"></span></button>',
        '<button type="button" class="btn btn-default printFactura" aria-label="Right Align">',
        '<span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>'
        ].join('');    
    }
    
}
function formatoEstadoFactura(value, row, index)
{
    $ret=''

    if(row.anulada==1)
    {        
        $ret='<span class="label label-warning">ANULADO</span>';
    }
    else
    {
        if(value==0)
            $ret='<span class="label label-danger">No facturado</span>';
        if(value==1)
            $ret='<span class="label label-success">T. Facturado</span>';
        if(value==2)
            $ret='<span class="label label-info">Facturado Parcial</span>';
    }
    
    return ($ret);
}
function formatoFacturaPagada(value, row, index)
{
    $ret=''

    if(row.anulada==1)
    {        
        $ret='<span class="label label-warning">Anulada</span>';
    }
    else
    {
        if(value==0)
            $ret='<span class="label label-danger"><i class="fas fa-times-circle"> No Pagada</i></span>';
        if(value==1)
            $ret='<span class="label label-success"><i class="fas fa-check-circle"></i> T. Pagada</span>';
        if(value==2)
            $ret='<span class="label label-info"><i class="fas fa-exclamation-circle"></i> Parcial</span>';
    }
    
    return ($ret);
}

window.eventosBotones = {
    'click .verFactura': function (e, value, row, index) {          
    //console.log(row);    
        agregarcargando();    
        agregarDatosInicialesFacturaModal(row);
     //   verFacturaModal(row);

    },
    'click .printFactura': function (e, value, row, index) {
        //alert(JSON.stringify(row));
        let imprimir = base_url("pdf/Factura/index/") + row.idFactura;
        window.open(imprimir);
    },
    'click .anularFactura': function (e, value, row, index) {         
        swal({
          title: 'Esta seguro?',
          text: 'Se anulara la factura seleccionada',         
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Aceptar',
          cancelButtonText:'Cancelar',                
        }).then(function () {
           anularFactura(row); 
           agregarcargando(); 
        })
        
    },      
};
function anularFactura(row)
{

     var data={
        idFactura:row.idFactura
    }
     $.ajax({
        type:"POST",
        url: base_url('index.php/Facturas/anularFactura'),
        dataType: "json",
        data:data
    }).done(function(res){    

       retornarTablaFacturacion();
      
    }).fail(function( jqxhr, textStatus, error ) {
    var err = textStatus + ", " + error;
    console.log( "Request Failed: " + err );
    }); 
}
function agregarDatosInicialesFacturaModal(row)
{
    var data={
        nFactura:row.nFactura,
        lote:row.lote,
        idFactura:row.idFactura
    }
     $.ajax({
        type:"POST",
        url: base_url('index.php/Facturas/mostrarDatosDetallesFactura'),
        dataType: "json",
        data:data
    }).done(function(res){
        console.log(res);
        if(res.response)
        {
            agregarDatosFacturaModal(res.datosFactura,row);
            mostrardatosmodal(res.detalleFactura);
        }      
    }).fail(function( jqxhr, textStatus, error ) {
    var err = textStatus + ", " + error;
    console.log( "Request Failed: " + err );
    }); 
}
function agregarDatosFacturaModal(res,row) {
    vmVistaPrevia.nit=res.detalle.nit;    
    vmVistaPrevia.numero=res.nfac;
    vmVistaPrevia.autorizacion=res.detalle.autorizacion;
    vmVistaPrevia.fechaLimiteEmision=res.detalle.fechaLimite
    vmVistaPrevia.codigoControl=row.codigoControl;
    vmVistaPrevia.llave=res.detalle.llaveDosificacion;    
    var fecha = moment(row.fechaFac, 'YYYY-MM-DD');
    vmVistaPrevia.fecha=fecha;
    vmVistaPrevia.manual=parseInt(res.detalle.manual);
}
function mostrardatosmodal(data)
{
        tipocambioFactura=data.data1.cambiovalor;
        vmVistaPrevia.tipocambio=data.data1.cambiovalor;
        vmVistaPrevia.moneda=parseInt(data.data1.moneda);
        vmVistaPrevia.datosFactura=data.data2;
        if (vmVistaPrevia.moneda==2) {
            for (let i = 0; i < vmVistaPrevia.datosFactura.length; i++) {
                vmVistaPrevia.datosFactura[i].facturaPUnitario = vmVistaPrevia.datosFactura[i].facturaPUnitario/tipocambioFactura;
            }
        } 

        vmVistaPrevia.ClienteFactura=data.data1.ClienteFactura;        
        vmVistaPrevia.ClienteNit=data.data1.ClienteNit;
        vmVistaPrevia.glosa=data.data1.glosa;
        vmVistaPrevia.pedido=data.data3.pedido;
        vmVistaPrevia.codigoControl=data.data3.codigoControl;
        vmVistaPrevia.generarCodigoQr();
        $("#facPrev").modal("show"); 
        quitarcargando();
}

$(document).ready(function () {
    returnInventarioTM()
    let $table = $('#tablaTMinventario');
  console.log($table);

//let $table = $('#tablaTMinventario');
//console.log($table);
$('#export').click(function () {
  $('#tablaTMinventario').tableExport({
    type:'excel',
    fileName: 'InventariosTM',
    numbers: {output : false}
  })
});

})
function returnInventarioTM() {
    agregarcargando();
    $.ajax({
      type: "POST",
      url: base_url('index.php/Reportes/showInventarioTM'),
      dataType: "json",
      data: {},
    }).done(function (res) {
      quitarcargando();
      //console.log(res);
      //datosselect = restornardatosSelect(res);
      $("#tablaTMinventario").bootstrapTable('destroy');
      $("#tablaTMinventario").bootstrapTable({
  
        data: res,
        striped: true,
        search: true,
        showColumns: true,
        filter: true,
        stickyHeader: true,
        stickyHeaderOffsetY: '50px',
        //showFooter: true,
        //footerStyle: footerStyle,
        columns: [
          {
            field: 'codigo',
            title: 'Código',
            sortable: true,
          },
          {
            field: 'descripcion',
            title: 'Descripción',
            sortable: true,
          },
          {
            field: 'cantidad',
            title: 'Cantidad',
            sortable: true,
            align: 'right'
          },
          {
            field: 'Unidad',
            title: 'Unidad',
            sortable: true,
            align: 'center'

          },
          {
            field: 'fecha',
            title: 'Fecha',
            width:'100px',
            sortable: true,
            align: 'center'
          },
          {
            field: 'almacen',
            title: 'Almacen',
            visible: false
          },
        ]
      });
    }).fail(function (jqxhr, textStatus, error) {
      var err = textStatus + ", " + error;
      console.log("Request Failed: " + err);
    });
  }
  function operateFormatter3(value, row, index) {
    num = Math.round(value * 100) / 100
    num = num.toFixed(2);
    return (formatNumber.new(num));
  }
  
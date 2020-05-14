let ini = moment().subtract(0, 'year').startOf('year').format('YYYY-MM-DD')
let fin = moment().subtract(0, 'year').endOf('year').format('YYYY-MM-DD')
$(document).ready(function () {
	$.fn.dataTable.ext.errMode = 'none';
	dataPicker()
	getPedidos()
	$('#reportrange').on('apply.daterangepicker', function (ev, picker) {
		getPedidos()
	});

})

function getPedidos() {
	agregarcargando()
	$.ajax({
		type: "POST",
		url: base_url('index.php/importaciones/pedidos/getPedidos'),
		dataType: "json",
		data: {
						ini:ini,
						fin:fin
					},
	}).done(function (res) {
		table = $('#table').DataTable({
			data: res,
			destroy: true,
			dom: 'Bfrtip',
			lengthMenu: [
				[10, 25, 50, -1],
				['10 filas', '25 filas', '50 filas', 'Todo']
			],
			pageLength: 10,
			columns: [{
					data: 'n',
					title: 'Nº',
					className: 'text-center',
				},
				{
					data: 'fecha',
					title: 'FECHA',
					className: 'text-center',
					render: formato_fecha,
				},
				{
					data: 'proveedor',
					title: 'PROVEEDOR',
					//sorting: nameCliente == '' || nameCliente == 'TODOS' ? true : false
				},
				{
					data: 'recepcion',
					title: 'RECEPCION',
					className: 'text-center',
					render: formato_fecha,
				},
				{
					data: 'formaPago',
					title: 'FORMA DE PAGO',
				},
				{
					data: 'pedidoPor',
					title: 'PEDIDO POR',
				},
				{
					data: 'total$',
					title: 'TOTAL $U$',
					className: 'text-right',
					sorting: false,
					render: numberDecimal
				},
				{
					data: 'totalBOB',
					title: 'TOTAL BOB',
					sorting: false,
					className: 'text-right',
					render: numberDecimal
				},
				{
					data: 'autor',
					title: 'CREADO POR',
					className: 'text-right',
					sorting: false,
					visible: false
				},
				{
					data: 'created_at',
					title: 'CREADO EN',
					className: 'text-center',
					render: formato_fecha_corta,
					visible: false
				},
				{
					data: null,
					title: '',
					width: '100px',
					className: 'text-center',
					render: buttons
				},
			],
			stateSave: true,
			stateSaveParams: function (settings, data) {
				data.order = []
			},
			buttons: [
				{
					extend: 'copy',
					text: '<i class="fas fa-copy" style="font-size:18px;"> </i>',
					titleAttr: 'Configuracion',
					header: false,
					title: null,
					exportOptions: {
						columns: [':visible'],
						title: null,
						modifier: {
							order: 'current',
						}
					}
				},
				{
					extend: 'excel',
					text: '<i class="fas fa-file-excel" aria-hidden="true" style="font-size:18px;"> </i>',
					titleAttr: 'ExportExcel',
					autoFilter: true,
					//messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.',
					title: 'Notas de Entrega Pendientes de Pago ',
					exportOptions: {
						columns: ':visible'
					},
				},
				{
					text: '<i class="fas fa-print" aria-hidden="true" style="font-size:18px;"></i>',
					action: function (e, dt, node, config) {
						window.window.print()
					}
				},
				{
					text: '<i class="fas fa-sync" aria-hidden="true" style="font-size:18px;"></i>',
					action: function (e, dt, node, config) {
						getPedidos()
					}
				},
				{
					extend: 'collection',
					text: '<i class="fa fa-cogs" aria-hidden="true" style="font-size:18px;"></i>',
					titleAttr: 'Configuracion',
					autoClose: true,
					buttons: [
						'pageLength',
						{
							extend: 'colvis',
							text: '<i class="fas fa-eye" aria-hidden="true"> Ver/Ocultar</i>',
							collectionLayout: 'fixed two-column',
							postfixButtons: ['colvisRestore']
						},
						{
							text: '<i class="fas fa-redo" aria-hidden="true"> Reestablecer</i>',
							className: 'btn btn-link',
							action: function (e, dt, node, config) {
								table.state.clear()
								getPedidos()
							}
						},

					]
				},
			],
			order: [],
			fixedHeader: {
				header: true,
				footer: true
			},
			//paging: false,
			//responsive: true,
			language: {
				buttons: {
					colvisRestore: "Restaurar",
					copyTitle: 'Información copiada',
					pageLength: {
						_: "VER %d FILAS",
						'-1': "VER TODO"
					},
					copySuccess: {
						_: '%d lineas copiadas',
						1: '1 linea copiada'
					},
				},
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Registros",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "Sin resultados encontrados",
				"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
				},
			},

		});
		quitarcargando();
	}).fail(function (jqxhr, textStatus, error) {
		let err = textStatus + ", " + error;
		console.log("Request Failed: " + err);
	});
}

function buttons (data, type, row) {
return `
	<button type="button" class="btn btn-default see">
		<span class="fa fa-search" aria-hidden="true">
		</span>
	</button>
	<button type="button" class="btn btn-default edit">
		<span class="fa fa-pencil" aria-hidden="true">
		</span>
	</button>
`
}

$(document).on("click", "button.see", function () {
	let row = table.row( $(this).parents('tr') ).data();
	modal.getPedido(row.id)
	
})

$(document).on("click", "button.edit", function () {
    let row = table.row( $(this).parents('tr') ).data();
	console.log( row.id );
	let editar = base_url("importaciones/pedidos/edit/") + row.id;
        window.location.href = editar;
})

const modal = new Vue({
	el: '#app',
	data: {
		numYear:'',
        fecha: '',
        formaPago:'',
        proveedor:'',
        pedidoPor:'',
        cotizacion:'',
        recepcion:'',
        glosa:'',
        totalDoc:0,
		tipoCambio: parseFloat(document.getElementById("mostrarTipoCambio").textContent),
		totalDoc:0,
        items:[],
	},
	methods:{
		getPedido(id){
			$.ajax({
				type: "POST",
				url: base_url('index.php/importaciones/pedidos/getPedido'),
				dataType: "json",
				data: {
						id:id,
					  },
			  }).done(function (res) {
				console.log(res);
				let num = '000'.substring(0, '000'.length - res.pedido.n.length) + res.pedido.n
				let year = moment(res.pedido.fecha).format('YY')
				modal.numYear = `${num}/${year}`
				modal.fecha = moment(res.pedido.fecha).format('DD/MM/YYYY')
				modal.formaPago = res.pedido.formaPago
				modal.pedidoPor = res.pedido.pedidoPor
				modal.cotizacion = res.pedido.cotizacion
				modal.recepcion = moment(res.pedido.recepcion).format('DD/MM/YYYY')
				modal.proveedor = res.pedido.proveedor
				modal.formaPago = res.pedido.formaPago
				modal.glosa = res.pedido.glosa
				modal.items = res.items
				modal.total()
				$("#pedidoModal").modal("show");
			  })
		},
		total(){
			if (this.items.length>0) {
			  this.totalDoc = this.items.map((item, index, array) => parseFloat(item.total)).reduce( (a,b)=> a+b)
			  console.log(this.totalDoc);
			  return this.totalDoc
			}
		  },
	},
	filters:{
		moneda:function(value){
			num=Math.round(value * 100) / 100
			num=num.toFixed(2);
			//return(num);
			return numeral(num).format('0,0.00');            
		}, 
	}
  })
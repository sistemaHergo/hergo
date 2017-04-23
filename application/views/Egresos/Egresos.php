<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div class="text-right" class="btn-group" id="toolbar">

          <a class="btn btn-primary btn-sm" href="#" target="_blank"><i class="fa fa-plus-circle fa-lg"></i>  VentaCaja</a>

          <a class="btn btn-primary btn-sm" href="<?php echo base_url("egresos/Notaentrega") ?>" target="_blank"><i class="fa fa-plus-circle fa-lg"></i>  NotaEntrega</a>

          <a class="btn btn-primary btn-sm" href="#" target="_blank"><i class="fa fa-plus-circle fa-lg"></i>  BajaProducto</a>

          </div>

            <div  id="toolbar2" class="form-inline">

              <button  type="button" class="btn btn-primary btn-sm" id="fechapersonalizada">
               <span>
                 <i class="fa fa-calendar"></i> Fecha
               </span>
                <i class="fa fa-caret-down"></i>
             </button>


              <select   class="btn btn-primary btn-sm" data-style="btn-primary" id="almacen_filtro" name="almacen_filtro">
                  <option>ALMACEN</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>

              </select>
              
              <select class="btn btn-primary btn-sm" name="tipo_filtro" id="tipo_filtro">
                  <option>TIPOMOV</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                 
              </select>

              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEgresoDetalle">  Launch demo modal </button>
           </div>





          <table 
            id="tegresos"
            data-toolbar="#toolbar2">
          </table>


      </div>

      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>




<!-- Modal -->
<div id="modalEgresoDetalle" class="modal fade" role="dialog">
  <div class="modal-dialog modal-95">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Detalle de Egresos 
        
        </h4>

      </div>
      <div class="modal-body">
         <!-- formulario PRIMERA FILA-->
          <div class="row"> <!--PRIMERA FILA-->
             <div class=" col-xs-6 col-sm-6 col-md-3">
              <label>Almacen:</label>
              <input id="almacen_imp" type="text" class="form-control" name="almacen_imp" readonly="">
             </div>
             <div class=" col-xs-6 col-sm-6 col-md-3">
              <label for="moneda_imp">Tipo de Egreso:</label>
              <input id="tipomov_imp" type="text" class="form-control" name="tipomov_imp" readonly="">
             </div>
             <div class="col-xs-6 col-sm-6 col-md-2">
                <label for="fechamov_imp" >Fecha:</label>
                <input id="fechamov_imp" type="text" class="form-control" name="fechamov_imp" readonly="">
             </div>
             <div class="col-xs-6 col-sm-6 col-md-2">
                <label for="moneda_imp">Moneda:</label>
                <input id="moneda_imp" type="text" class="form-control" name="moneda_imp" readonly="">

             </div>
             <div class="col-xs-12 col-sm-6 col-md-2">
                <label for="fechamov_imp" ># Movimiento:</label>
                <input id="nmov_imp" type="text" class="form-control" name="nmov_imp" readonly="">
             </div>
          </div> <!-- div class="form-group-sm row" PRIMERA FILA -->
          <div class="row"> <!--SEGUNDA FILA-->
                 <div class="col-xs-12 col-lg-6 col-md-6">
                   <label >Cliente:</label>
                   <input id="proveedor_imp" type="text" class="form-control" name="proveedor_imp" readonly="">
                 </div>
                 <div class="col-xs-4 col-sm-4 col-md-2">
                       <label>Pedido Cliente:</label>
                       <input id="ordcomp_imp" type="text" class="form-control" name="ordcomp_imp" readonly="">
                 </div>
                 <div class="col-xs-4 col-sm-4 col-md-2">
                       <label>Fecha de Pago:</label>
                       <input id="nfact_imp" type="text" class="form-control" name="nfact_imp" readonly="">
                 </div>
                 <div class="col-xs-4 col-sm-4 col-md-2">
                       <label>VACIO:</label>
                       <input id="ningalm_imp" type="text" class="form-control" name="ningalm_imp" readonly="">
                 </div>
              </div><!-- div class="form-group-sm row" SEGUNDA FILA-->
              <hr>
         <table class="table-striped"
              data-toggle="table"
              id="tingresosdetalle">
          </table>
          <!--TOTALES SISTEMA-->
           <div class="col-md-6 col-xs-12 pull-left" style="padding: 0px">
            <h2 style="background-color: #007da7" >Facturado</h2>
          </div>

          <div class="col-md-6 col-xs-12 pull-right" style="padding: 0px">
            <div class = "input-group col-md-12 col-xs-12">
              <span class = "input-group-addon">$</span>
              <!--mostrar el total bolivianos factura-->
              <input type = "text" class="form-control form-control-sm text-right tiponumerico" id="" disabled="">
              <span class = "input-group-addon">Bs</span>
              <!--mostrar el total bolivivanos sistema-->
              <input type = "text" class="form-control form-control-sm text-right tiponumerico" id="totalbsdetalle" disabled="">
             </div>
          </div>
          <hr>

          <!--TOTALES DOCUMENTO O FACTURA

          <div class="col-md-6 col-xs-12 pull-right" style="padding: 0px">
            <div class = "input-group col-md-12 col-xs-12">
              <span class = "input-group-addon">$ FAC</span>
              <!--mostrar el total dolares factura
              <input type = "text" class="form-control form-control-sm text-right tiponumerico" id="" disabled="">
              <span class = "input-group-addon">$ SIS</span>
              <!--mostrar el total dolares sistema
              <input type = "text" class="form-control form-control-sm text-right tiponumerico" id="totalsusdetalle" disabled="">
             </div>
          </div>-->

          <div class="row">
                <div class="col-xs-12 col-md-12">
                  <!--insertar costo de articulo a ingresar-->
                  <label for="observaciones_imp">Observaciones:</label>
                  <input type="text" class="form-control" id="obs_imp" name="obs_imp"/> 
              </div>
                
          </div>
          <div class="clearfix"></div>

      </div>
      <div class="modal-footer">
        <span id="pendienteaprobado"></span>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>

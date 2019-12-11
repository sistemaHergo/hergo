<div class="row">
  <div class="col-xs-12">
    <div class="box">
      
      <section class="content">
      <div class="box-header">
          <div class="form forPrint">
            <div class="form-group row">
              <button  type="button" class="btn btn-primary btn-sm" id="fechapersonalizada">
                <span>
                  <i class="fa fa-calendar"></i> Fecha
                </span>
                  <i class="fa fa-caret-down"></i>
              </button>
                <select   class="btn btn-primary btn-sm" data-style="btn-primary" id="almacen_filtro" name="almacen_filtro">
                  <option value=<?= $id_Almacen_actual ?> selected="selected"><?= $almacen_actual ?></option>
                  <?php foreach ($almacen->result_array() as $fila): ?>
                  <option value=<?= $fila['idalmacen'] ?> ><?= $fila['almacen'] ?></option>
                  <?php endforeach ?>
                  <option value="">TODOS</option>
                </select>
            </div>

              <div class="form-group row">
                  <label class="col-sm-1 col-form-label">Cliente:</label>
                  <span style="margin-left: 10px;display: none;" id="cargandocliente">
                    <i class="fa fa-spinner fa-pulse fa-fw"></i>
                  </span>
                  <div class="col-sm-10">
                    <input class="form-control form-control-sm" type="text" id="cliente_egreso" name="cliente_egreso" value="TODOS">
                  </div>  
                  <input type="text" readonly="true" name="idCliente" id="idCliente" class="hidden" value="TODOS">
                  <div class="col-sm-1">  
                    <button type="button" class="btn btn-primary btn-sm" id="refresh">
                      <span>
                      <i class="fa fa-share-square"></i>
                      </span>
                    </button>
                  </div>
              </div>
          </div>

          <div class="text-center">
            <h2>NOTAS DE ENTREGA POR FACTURAR NEW - <span id="tituloReporte"></span></h2>
            <h4 id="ragoFecha"></h4>
          </div>
        </div>
        <div class="box-body">
          <table id="tablaNotasEntregaFacturar" class="table table-hover table-striped table-sm" style="width:100%">
          </table>
          </div>
      <!-- /.box-body -->
        </section>
      
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>


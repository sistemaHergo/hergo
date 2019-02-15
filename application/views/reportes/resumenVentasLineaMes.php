<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="container">
        <div class="box-body">
        <button class="btn btn-success pull-right" id="export" data-toggle="tooltip" title="Excel"><i class="far fa-file-excel"> </i> Excel </button>
            <div id="toolbar2" class="form-inline">

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
              <button  type="button" class="btn btn-primary btn-sm" id="refresh">
                        <span>
                        <i class="fa fa-share-square"></i>
                        </span>
                    </button>
            </div>
              <div class="text-center">
              <h2>RESUMEN VENTAS LINEA MES - <span id="tituloAlmacen"></span></h2>
              <h4 id="ragoFecha"></h4>
            </div>
            <table 
              id="tablaResumenVentasLineaMes" 
              data-toolbar="#toolbar2"
              data-toggle="table">
            </table>

          </div>
        </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>


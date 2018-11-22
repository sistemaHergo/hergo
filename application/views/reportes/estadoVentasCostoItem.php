<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
          <div class="form-inline">
            <button class="btn btn-default pull-right" id="excel" data-toggle="tooltip" title="Excel"><i class="far fa-file-excel"> </i> Excel </button>
          </div>
          <div id="toolbar2" class="form-inline">
                <select   class="btn btn-primary btn-sm" data-style="btn-primary" id="almacen_filtro" name="almacen_filtro">
                    <option value=<?= $id_Almacen_actual ?> selected="selected"><?= $almacen_actual ?></option>
                    <?php foreach ($almacen->result_array() as $fila): ?>
                      <option value=<?= $fila['idalmacen'] ?> ><?= $fila['almacen'] ?></option>
                    <?php endforeach ?>
                    <option value="">TODOS</option>
                </select>

                <select id="moneda" class="btn btn-primary btn-sm">
                    <option value="0">BOB</option>
                    <option value="1">$U$</option>
                </select>

                <button  type="button" class="btn btn-primary btn-sm" id="refresh">
                    <span>
                    <i class="fa fa-share-square"></i>
                    </span>
                </button>

                
          </div>
          <div class="text-center">
            <h2>ESTADO DE VENTAS Y COSTOS POR ITEM <span > Gestion Actual</span></h2>
            <h3 id="tituloReporte"></h3>
            <h4 id="monedaTitulo"></h4>
          </div>
          <table 
            id="estadoVentasCostos" 
            data-toolbar="#toolbar2"
            data-toggle="table" >
          </table>
          
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>

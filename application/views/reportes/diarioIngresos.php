<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div id="toolbar2" class="form-inline">
                    <button type="button" class="btn btn-primary btn-sm" id="fechapersonalizada">
                        <span>
                            <i class="fa fa-calendar"></i> Fecha
                        </span>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <select   class="btn btn-primary btn-sm" data-style="btn-primary" id="almacen_filtro" name="almacen_filtro">
                        <?php foreach ($almacen->result_array() as $fila): ?>
                        <option value=<?= $fila['idalmacen'] ?> ><?= $fila['almacen'] ?></option>
                        <?php endforeach ?>
                        <option value="">TODOS</option>
                    </select>
                    <select class="btn btn-primary btn-sm" name="tipo_filtro" id="tipo_filtro">
                <?php foreach ($tipoingreso->result_array() as $fila): ?>
                  <option value="<?= $fila['id'] ?>" <?= $fila['id']==2?"selected":""  ?>><?= strtoupper($fila['tipomov']) ?></option>
                <?php endforeach ?>
                <option value="">TODOS</option>
              </select>



                </div>
                <!--row-->
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

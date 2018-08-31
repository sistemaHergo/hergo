<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div id="toolbar2" class="form-inline">
                    <select   class="btn btn-primary btn-sm" data-style="btn-primary" id="almacen_filtro" name="almacen_filtro">
                        <?php foreach ($almacen->result_array() as $fila): ?>
                        <option value=<?= $fila['idalmacen'] ?> ><?= $fila['almacen'] ?></option>
                        <?php endforeach ?>
                        <option value="" >TODOS</option>
                    </select>

                    <button  type="button" class="btn btn-primary btn-sm" id="saldos">
                        <span>
                        <i class="fa fa-share-square"></i>
                        </span>
                    </button>
                </div>
                <div class="text-center">
                    <h2>Saldos Actuales de Items  -
                        <span id="tituloReporte"></span>
                    </h2>
                    <h3 id="nombreArticulo"></h3>
                </div>
                <table id="tablaSaldos" data-toolbar="#toolbar2" data-toggle="table" >
                </table>
            </div>
        </div>
    </div>
</div>
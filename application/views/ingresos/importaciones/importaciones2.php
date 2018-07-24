<?php

    $cont=(isset($dcab))?true:false;//si existe datos cabecera true si existe => editar
    $idalmacen=0;
    $idtingreso=0;
    $idmoneda=0;
    $idproveedor=0;
    if($cont)
    {
        $originalDate = $dcab->fechamov;
        //$originalDate = str_replace("/", "-", $originalDate);
        $newDate = date("Y-m-d", strtotime($originalDate));//revisar mes y año
       /* echo $originalDate."\n";
        echo $newDate;
        die();*/
        $idalmacen=$dcab->idalmacen;
        $idtingreso=$dcab->idtipomov;
        $idmoneda=$dcab->idmoneda;
        $idproveedor=$dcab->idproveedor;
        $idingresocompraslocales=$idtingreso;
    }
    else
    {
      $idingresocompraslocales=$idingreso;
    }
?>
<style>
    .totales{
      font-size: 1.3em;
      font-weight: bold;
    }

    input {
      height: 50px;
    }

    input:focus {
      background-color: rgba(60, 141, 188, 0.47);
      ;
      /*color: white;*/
      font-weight: 700;
    }

    select:focus {
      background-color: rgba(60, 141, 188, 0.47);
      /*color: white;*/
    }

    input[type=date]::-webkit-outer-spin-button,
    input[type=date]::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
</style>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <!--<h3 class="box-title">Ingreso Importaciones</h3>-->
      </div>
      <div class="box-body">
        <form action=" " method="post"  id="form_ingresoImportaciones">
          <div class="form">
          <!-- formulario PRIMERA FILA-->
            <?php if ($cont): ?>
                <input id="idingresoimportacion" name="idingresoimportacion" type="text" class="hidden"  hidden value="<?= $dcab->idIngresos ?>">
            <?php endif ?>
            <div class="row"> <!--PRIMERA FILA-->
               <div class=" col-xs-6 col-sm-6 col-md-3">
                <label>Almacen:</label>
                <select class="form-control form-control-sm" id="almacen_imp" name="almacen_imp" <?= ($cont)?"disabled":"" ?>>
                   <?php foreach ($almacen->result_array() as $fila): ?>
                     <option value=<?= $fila['idalmacen'] ?> <?= ($idalmacen==$fila['idalmacen'])?"selected":"" ?> ><?= $fila['almacen'] ?></option>
                     <option value=<?= $id_Almacen_actual ?> selected="selected"><?= $almacen_actual ?></option>
                   <?php endforeach ?>
                </select>
               </div>
               <div class=" col-xs-6 col-sm-6 col-md-3">
                <input type="" name="tipomov_imp" value="<?= (isset($idingreso)?$idingreso:0)?>" class="hidden">
                <label for="tipomov_imp">Tipo de Ingreso:</label>
                <select class="form-control form-control-sm" id="tipomov_imp2" name="tipomov_imp2"  <?= ($cont)?"disabled":"" ?> disabled>
                   <?php foreach ($tingreso->result_array() as $fila): ?>
                    <?php if ($cont): ?>
                      <?php if ($idtingreso==$fila['id']): ?>
                        <option value=<?= $fila['id'] ?> "selected"><?= $fila['tipomov'] ?></option>
                      <?php endif ?>
                    <?php else: ?>
					
          					  <?php if ($idingreso==$fila['id']): ?>
                                	<option value=<?= $fila['id'] ?> <?= ($idingreso==$fila['id'])?"selected":"" ?>><?= $fila['tipomov'] ?></option>
          					  <?php endif ?>
                    <?php endif ?>
                     
                   <?php endforeach ?>
                </select>
               </div>
               <div class="col-xs-6 col-sm-6 col-md-2">

                  <label for="fechamov_imp" >Fecha:</label>
                  <input id="fechamov_imp" type="text" class="form-control form-control-sm fecha_ingreso" 
                  name="fechamov_imp" placeholder="Fecha" value="<?= ($cont)?$newDate:''  ?>"  <?= ($cont)?"disabled":"" ?> autofocus/>
               </div>
               <div class="col-xs-6 col-sm-6 col-md-2">
                  <label for="moneda_imp">Moneda:</label>
                  <select class="form-control form-control-sm" id="moneda_imp" name="moneda_imp">
                    <option value="1" <?= ($idmoneda==1)?"selected":"" ?> >BOLIVIANOS</option>
                    <option value="2" <?= ($idmoneda==2)?"selected":"" ?>>DOLARES </option>
                  </select>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-2">
                  <label for="fechamov_imp" ># Movimiento:</label>
                  <input id="nmov_imp" type="number" class="form-control" name="nmov_imp" placeholder="# Movimiento" disabled value="<?= ($cont)?$dcab->n:""  ?>"/>
               </div>
            </div> <!-- div class="form-group-sm row" PRIMERA FILA -->
            <div class="row"> <!--SEGUNDA FILA-->
                   <div class="col-xs-12 col-lg-6 col-md-6">
                     <label >Proveedor:</label>
                     <!--<select class="form-control" id="proveedor_imp" name="proveedor_imp">-->
                       <select class="form-control selectpicker" data-size="5" data-live-search="true" id="proveedor_imp" name="proveedor_imp">
                        <?php foreach ($proveedor->result_array() as $fila): ?>
                         <option value=<?= $fila['idproveedor'] ?> <?= ($idproveedor==$fila['idproveedor'])?"selected":"" ?>><?= $fila['nombreproveedor'] ?></option>
                       <?php endforeach ?>
                      </select>

                      <!-- Busqueda con select cambiar a autocomplete-->

                   </div>
                   <div class="col-xs-4 col-sm-4 col-md-2">
                         <label>Orden de Compra:</label>
                         <input id="ordcomp_imp" type="text" class="form-control form-control-sm" name="ordcomp_imp" placeholder="Orden de Compra" value="<?= ($cont)?$dcab->ordcomp:""  ?>" >
                   </div>
                   <div class="col-xs-4 col-sm-4 col-md-2">
                         <label>N° Factura: <small id="consinfac" style="font-size: 11px;color: #00a65a;">(con Factura)</small></label>
                         <input id="nfact_imp" name="nfact_imp" type="text" style="text-transform:uppercase" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control form-control-sm"  placeholder="# Factura" value="<?= ($cont)?$dcab->nfact:""  ?>">
                   </div>
                   <div class="col-xs-4 col-sm-4 col-md-2">
                         <label>N° Ingreso:</label>
                         <input id="ningalm_imp" type="text" class="form-control form-control-sm" name="ningalm_imp" placeholder="# Ingreso" value="<?= ($cont)?$dcab->ningalm:""  ?>">
                   </div>
                </div><!-- div class="form-group-sm row" SEGUNDA FILA-->


                <hr>
                <div class="row"> <!--TERCERA FILA-->
                  <div class="col-xs-12 col-md-2 has-feedback has-feedback-left">
                      <!--seleccionar codigo de articulo de la base de datos-->
                     <label for="articulo_imp" style="float: left;">Codigo:</label><span style="margin-left: 10px;display: none;" id="cargandocodigo" ><i class="fa fa-spinner fa-pulse fa-fw"></i></span>
                     <!--<select  class="form-control selectpicker" data-size="5" data-live-search="true" id="articulo_imp" name="articulo_imp" >
                        <?php //foreach ($articulo->result_array() as $fila): ?>
                         <option id=<?php //$fila['idArticulos'] ?> descripcion="<?php //$fila['Descripcion'] ?>"><?php //$fila['CodigoArticulo'] ?></option>
                       <?php //endforeach ?>
                     </select> -->
                     <input class="form-control form-control-sm" type="text" id="articulo_imp" name="articulo_imp"/>
                     <div style="right: 22px;top:32px;position: absolute;" id="codigocorrecto"><i class="fa fa-times" style="color:#bf0707" aria-hidden="true"></i></div>
                  </div>
                  <div class="col-xs-12 col-md-4">
                      <!--mostrar descripcion de articulo segun codigo-->
                     <label for="descripcion_imp">Descripcion:</label>
                     <input type="text" class="form-control form-control-sm" id="Descripcion_imp" name="Descripcion_imp" disabled/>
                  </div>
                  <div class="col-xs-4 col-md-2">
                       <!--mostrar unidad de articulo segun codigo-->
                     <label for="">Unidad:</label>
                     <input type="text" class="form-control form-control-sm" id="unidad_imp" disabled/>
                  </div>
                  <div class="col-xs-4 col-md-2 ">
                      <!--mostrar costo promedio ponderado de articulo segun codigo-->
                     <label for="costo_imp">CostoPromedio:<span style="margin-left: 10px; display: none;" class="cargandoCostoSaldo"><i class="fa fa-spinner fa-pulse fa-fw"></i></span></label>
                     <input type="text" class="form-control form-control-sm text-right tiponumerico" id="costo_imp" disabled/>
                  </div>
                   <div class="col-xs-4 col-md-2">
                      <!--mostrar saldo en almacen de articulo segun codigo-->
                     <label for="saldo_imp">Saldo:<span style="margin-left: 10px; display: none;" class="cargandoCostoSaldo"><i class="fa fa-spinner fa-pulse fa-fw"></i></span></label>
                      <input type="text" class="form-control form-control-sm text-right tiponumerico" id="saldo_imp" disabled/>
                  </div>

                 </div><!-- div class="form-group-sm row"  TERCERA FILA-->
                 <div class="form-group row"> <!--CUARTA FILA-->

                  <div class="col-xs-12 col-md-4">
                      <!--insertar costo de articulo a ingresar-->

                  </div>

                  <div class="col-xs-4 col-md-2">
                        <!--insertar cantidad de productos a ingresar-->
                      <label>Cantidad:</label>
                      <input type="text" style="text-align:right;" class="form-control form-control-sm" id="cantidad_imp" name="cantidad_imp" />
                  </div>
                  <div class="col-xs-4 col-md-2">
                      <!--insertar costo de articulo a ingresar-->
                      <label><?= $idingresocompraslocales==2? "Total:":"Costo Unitario:" ?></label> <!--CAMBIO PARA COMPRAS LOCALES-->
                      <input type="text" style="text-align:right;" class="form-control form-control-sm" id="punitario_imp" name="punitario_imp" />
                  </div>
                  <div class="col-xs-4 col-md-2">
                        <!--insertar cantidad de productos a ingresar-->
                      <label>Costo Unitario:</label>
                      <input type="text" class="form-control form-control-sm tiponumerico" id="constounitario" name="" disabled/>
                  </div>

                  <div class="col-xs-12 col-md-2">
                  <label></label>
                  <button type="button" class="form-control btn btn-success" id="agregar_articulo" name="agregar_articulo" style="margin-top: 4px;" >Añadir</button>
                  </div>
               </div><!--row CUARTA FILA -->

          </div> <!-- /.class="form" -->
          <hr>
        <!--Tabla para mostrar articulos ingresados-->
              <div class="table-responsive">
                <table  class="table table-condensed table-bordered table-striped">
                  <thead>
                    <tr>
                      <th class="col-sm-1" >Código</th>
                      <th class="col-sm-6">Artículo</th>
                      <th class="col-sm-1" class="text-right">Cantidad</th>
                      <th class="col-sm-1" class="text-right">P/U Documento</th> <!--nuevo-->
                      <th class="col-sm-1" class="text-right">Total Documento</th> <!--nuevo-->
                      <th class="text-right">C/U Sistema</th><!--CAMBIO PARA COMPRAS LOCALES "Costo Unitario":"Total" --> 
                      <th class="text-right">Total</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyarticulos">
                    <?php if ($cont): ?>
                        <?php foreach ($detalle as $fila): ?>
                          <?php 
                            $punitariofac= $fila['cantidad']==""?0:$fila['cantidad'];
                            $punitariofac=$fila['totaldoc'] / $punitariofac;
                          ?>
                            <tr>
                                <td><input type="text" class="estilofila" disabled value="<?= $fila['CodigoArticulo'] ?>"></input></td>
                                <td><input type="text" class="estilofila" disabled value="<?= $fila['Descripcion'] ?>"></input</td>
                                <td class="text-right"><input type="text" class="estilofila tiponumerico" disabled value="<?= $fila['cantidad'] ?>"></input></td>
                                <td class="text-right"><input type="text" class="estilofila tiponumerico" disabled value="<?= $punitariofac ?>"></input></td><!--nuevo-->
                                <td class="text-right"><input type="text" class="totalDoc estilofila tiponumerico" disabled value="<?= $fila['totaldoc'] ?>"></input></td><!--nuevo-->
                                <td class="text-right"><input type="text" class="estilofila tiponumerico" disabled value="<?= $fila['punitario'] ?>"></input></td>
                                <td class="text-right"><input type="text" class="totalCosto estilofila tiponumerico" disabled value="<?= $fila['total'] ?>"></input></td>
                                <td><button type="button" class="btn btn-default eliminarArticulo" aria-label="Left Align"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>

                  </tbody>
                </table>
              </div> <!--div class="table-responsive"-->

            <div class="form-group row">
              <div class="col-md-6 col-xs-12">
                
              </div>
              <div class="col-md-6 col-xs-12">
                <div class = "input-group col-md-12 col-xs-12">
                  <span class = "input-group-addon totales" id="nombretotaldoc">Bs. Doc.</span>
                  <!--mostrar el total bolivianos factura o documento-->
                  <input type = "text" class="form-control form-control-sm text-right tiponumerico totales" disabled id="totalacostodoc">
                  <span class = "input-group-addon totales" id="nombretotalsis" >Bs. Sis.</span>
                  <!--mostrar el total bolivivanos sistema-->
                  <input type = "text" class="form-control form-control-sm text-right tiponumerico totales" disabled id="totalacostobs">
                 </div>
              </div>
            </div><!--row-->
            <hr>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                  <!--insertar costo de articulo a ingresar-->
                  <label for="observaciones_imp">Observaciones:</label>
                  <input type="text" class="form-control" id="obs_imp" name="obs_imp" value="<?= ($cont)?$dcab->obs:""  ?>" />
              </div>
                <hr>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12">
                <?php if ($cont): ?>
                    <button type="button" class="btn btn-primary" id="actualizarMovimiento">Actualizar Movimiento</button>
                      <?php if ($dcab->anulado==0): ?>
                        <button type="button" class="btn btn-warning" id="anularMovimiento">Anular Movimiento</button>  
                      <?php else: ?>
                        <button type="button" class="btn btn-info" id="recuperarMovimiento">Recuperar Movimiento</button>  
                      <?php endif ?>
                      
                    <button type="button" class="btn btn-danger" id="cancelarMovimientoActualizar">Cancelar</button>
                <?php else: ?>
                    <button type="button" class="btn btn-primary" id="guardarMovimiento">Guardar Movimiento</button>
                    <button type="button" class="btn btn-danger" id="cancelarMovimiento">Cancelar Movimiento</button>
                <?php endif ?>


              </div>
            </div>
        </form>
      </div> <!-- /.box-body -->
    </div> <!-- /.class="box" -->
  </div> <!-- /.class="col-xs-12" -->
</div> <!-- /.class="row" -->

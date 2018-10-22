<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
          <div class="text-right">
              <button class="btn btn-default text-center btnnuevo" style="margin-bottom :10px" data-toggle="modal" data-target="#modalmarca">Agregar nueva Marca</button>
          </div>                    
          <table 
              data-toggle="table"
             data-height="550"
             data-search="true"
             data-show-toggle="true"
             data-show-columns="true"
             data-locale="es-MX"
             data-search="true"
             data-striped="true"
             >
              <thead>
                  <tr>
                      <th>Marca</th>
                      <th>Sigla</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>                   
                 <?php foreach ($marca->result_array() as $fila): ?>
                   <tr id="<?= $fila['idMarca'] ?>">
                     <td><?= $fila['Marca'] ?></td>
                     <td><?= $fila['Sigla'] ?></td>
                     <td>
                       <div class="text-right">
                        <button class="btn btn-default botoneditar"><i class="fa fa-pencil" ></i></button>
                       </div>
                     </td>
                   </tr>
                 <?php endforeach ?>                                          
              </tbody>              
          </table>
          
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>

<!-- Modal -->
<form action=" " method="post"  id="form_marcaArticulos">
  <div class="modal fade" id="modalmarca" role="dialog">
      <input type="" name="cod" value="" id="cod_marca" hidden> <!-- input oculto para el codigo de almacen-->
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title modalmarcatitulo"></h3>
           </div>
                <!--MODAL BODY-->
          <div class="modal-body form form-horizontal">
            <fieldset>
            <!-- Nombre de Marca-->
              <div class="form-group">
                <label class="col-md-3 control-label">Marca</label>  
                <div class="col-md-9 inputGroupContainer">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                      <input  autofocus name="marca" placeholder="Nombre de la Marca" id="modalnombremarca" class="form-control"  type="text" style="text-transform:uppercase; " onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>
                </div>
                
              </div>
                <!-- sigla de marca-->
              <div class="form-group">
                <label class="col-md-3 control-label" for="modalsiglamarca">Sigla</label>  
                <div class="col-md-9 inputGroupContainer">
                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-screenshot"></i></span>
                <input  name="sigla" placeholder="Sigla de la Marca" class="form-control" id="modalsiglamarca" type="text"  style="text-transform:uppercase; " onkeyup="javascript:this.value=this.value.toUpperCase();">
                  </div>
                </div>
                
              </div>
              
              </div>-->
              <!-- Uso -->
            </fieldset>                 
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="bguardar_marca">Guardar</button>
            </div>
          </div> <!-- /.<div class="modal-body form">-->
        </div>
      </div> <!-- /. modal -->
  </div>
</form>

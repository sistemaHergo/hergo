<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
          <button id="export" class="btn btn-success pull-right"><i class="far fa-file-excel"> </i> Excel</button>
          <button onclick="window.print();" class="btn btn-primary pull-right" ><i class="fa fa-print"> </i> Imprimir</button>
          <hr>
          <div id="toolbar2" class="form-inline">
            <?php
              $this->load->view('reportHead/buttonDate');
              $this->load->view('reportHead/selectAlm');
              $this->load->view('reportHead/buttonRefresh');
            ?>
          </div>
          <div class="text-center">
            <h2>LIBRO DE VENTAS - <span id="tituloAlmacen"></span></h2>
            <h4 id="ragoFecha"></h4>
          </div>
          <table 
            id="tablaLibroVentas" 
            data-toolbar="#toolbar2"
            data-toggle="table">
          </table>
          <div class="form-group row">
            <div class="col-md-6 col-xs-12">
               <div class = "input-group col-md-12 col-xs-12">
               <span class = "input-group-addon">Total</span>
               <input type = "text" class="form-control form-control-sm text-right tiponumerico" disabled id="fTotal" value="">
               <span class = "input-group-addon">Man.</span>
               <input type = "text" class="form-control form-control-sm text-right tiponumerico" disabled id="fManuales" value="">
               <span class = "input-group-addon" >Comp.</span>
               <input type = "text" class="form-control form-control-sm text-right tiponumerico" disabled id="fComputarizadas" value="">
                <span class = "input-group-addon" >Válidas</span>
                <input type = "text" class="form-control form-control-sm text-right tiponumerico" disabled id="fValidas" value="">
                <span class = "input-group-addon" >Anuladas</span>
                <input type = "text" class="form-control form-control-sm text-right tiponumerico" disabled id="fAnuladas" value="">
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
              <div class = "input-group col-md-12 col-xs-12">
               <span class = "input-group-addon">Total Facturado</span>
               <input type = "text" class="form-control form-control-sm text-right tiponumerico" disabled id="totalFacturas" value="">
               <span class = "input-group-addon" >Debito Fiscal</span>
               <input type = "text" class="form-control form-control-sm text-right tiponumerico" disabled id="totalDebito" value="">
              </div>
          </div>
        </div><!--row-->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>


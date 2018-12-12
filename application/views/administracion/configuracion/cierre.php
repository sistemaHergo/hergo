<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <h1>Cierre de Gestión</h1>
                <div id="steps">
                    <h3>Verificar Pendientes</h3>
                    <section>
                        <p>Verificar Ingresos pendientes de aprobación y Ventas Caja sin Facturar de la gestión actual.</p>
                        <div class="box-body">
                            <div id="toolbar2" class="form-inline">
                                <button  type="button" class="btn btn-primary" id="btnVerificarPendientes">
                                    <span>
                                        <i class="fa fa-check"> Verificar </i>
                                    </span>
                                </button>
                            </div>
                            <table 
                                id="verificarPendientes" 
                                data-toolbar="#toolbar2"
                                data-toggle="table">
                            </table>
                        </div>
                    </section>

                    <h3>Verificar Negativos</h3>
                    <section>
                        <p>Verificar Artículos con saldo negativo de la gestión actual.</p>
                        <div class="box-body">
                            <div id="toolbar3" class="form-inline">
                                <button  type="button" class="btn btn-primary" id="btnVerificarNegativos">
                                    <span>
                                        <i class="fa fa-check"> Verificar </i>
                                    </span>
                                </button>
                            </div>
                            <table 
                                id="verificarNegativos" 
                                data-toolbar="#toolbar3"
                                 data-height="450">
                            </table>
                        </div>
                    </section>

                    <h3>Datos Inventario Inicial</h3>
                    <section>
                        <p> Fecha de Inicio de Gestiòn y tipo de cambio</p>
                        <div class="box-body">
                            <div class="form-group fecha-cambio">
                                <label class="col-md-3 control-label"><span ></span> Fecha</label>
                                <div class="col-md-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-screenshot"></i>
                                        </span>
                                        <input class="form-control" name="fechaCambio" id="fechaCambio" type="text" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Tipo Cambio</label>
                                <div class="col-md-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-screenshot"></i>
                                        </span>
                                        <input placeholder="Establecer nuevo tipo de cambio" class="form-control" name="tipocambio" id="tipocambio" type="text" autofocus>
                                        <input name="id"   id="id" type="text" class="hidden">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <h3>Backup</h3>
                    <section>
                        <p>Crear backup de la gestión actual</p>
                    </section>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
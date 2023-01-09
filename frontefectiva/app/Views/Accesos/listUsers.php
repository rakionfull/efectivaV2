<?=$this->extend('Layout/main')?> 
<?=$this->section('content')?> 
<div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body ">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h4 class="card-title">Lista de Usuarios</h4>
                                </div>
                              
                                <div class="col-md-4 offset-md-4">
                                   
                                    <a href="<?=base_url('accesos/createUser'); ?>" class="float-right btn btn-primary waves-effect waves-light"><i class=" fas fa-plus-circle align-middle ml-2"></i>  Agregar</a>
                                </div>
                                <div class="col-md-12" style="margin-top:0.5rem" id="alert_formulario">
                                    
                                </div>
                            </div>
                           
                        </div>
                        <div class="card-body">
                      
                        <div class="table-responsive">
                            <table id="table_users" class="table table-centered datatable dt-responsive nowrap" data-page-length="5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>N°</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Usuario</th>
                                        <th>Fecha Registro</th>
                                        <th style="width: 120px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                  
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
        </div>
<?=$this->endSection()?> 
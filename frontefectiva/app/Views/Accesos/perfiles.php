<?=$this->extend('Layout/main')?> 
<?=$this->section('content')?> 
        <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body ">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h4 class="card-title">Lista de Perfiles</h4>
                                </div>
                              
                                
                            </div>
                            <div class="row mt-2 d-flex justify-content-between">
                                <div class="col-md-6">
                                   
                                    <button type="button" id="btnAgregar_perfil" class=" btn btn-primary waves-effect waves-light"><i class=" fas fa-plus-circle align-middle mr-2 ml-2"></i> Agregar</button>
                                </div>
                                <div class="col-md-4">
                                    <div class="row g-3 d-flex justify-content-end">
                                        <div class="col-auto">
                                            <label for="inputPassword6" class="col-form-label">Estado</label>
                                        </div>
                                        <div class="col-auto">
                                            <select name="" id="" class="form-control">
                                                    <option value="">Activos</option>
                                                    <option value="">Inactivos</option>
                                            </select>
                                        </div>
                                       
                                    
                                    </div>
                                   
                                    <!-- <a href="<?=base_url('createUser'); ?>" class="float-right btn btn-primary waves-effect waves-light"><i class="fas fa-search align-middle ml-2"></i>  Filtro</a>
                                 -->
                                </div>
                                <div class="col-md-12" style="margin-top:0.5rem" id="alert_formulario">
                                    
                                    </div>
                            </div>
                            <?php 
                                $session = session();
                                    if($session->getFlashdata('error') != '')
                                    {
                                    echo $session->getFlashdata('error');;
                                    }
                                ?>
                        </div>
                        <div class="card-body">
                      
                            <div class="table-responsive">
                                            <table id="table_perfiles" class="table table-centered datatable dt-responsive nowrap" data-page-length="5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Id</th>
                                                        
                                                        <th>perfil</th>
                                                        <th>descripcion</th>
                                                        <th>Estado</th>
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
              
                <div class="modal fade" id="modal_perfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                |   <div class="modal-dialog modal-lg" role="document">
                         <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="title-perfil"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            <div class="modal-body">
                                <form action="" id="form_perfil" class="in-line">
                                    <input type="hidden" id="id_perfil">
                                    
                                    <div class="col-12-lg">
                                        <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <span>Perfil: </span>
                                                        <input type="text" class="form-control form-control-sm" id="nom_perfil"  onkeyup="this.value = this.value.toUpperCase();" onKeyPress="return soloLetra(event);">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <span>Descripción: </span>
                                                        <input type="text" class="form-control form-control-sm" id="desc_perfil"  onkeyup="this.value = this.value.toUpperCase();" onKeyPress="return soloLetra(event);">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <span>Estado: </span>
                                                        <select name="" id="est_perfil" class="form-control form-control-sm">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">Activo</option>
                                                        <option value="2">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                        </div>
                                    </div>
                                </form>  
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="Agregar_Perfil">Agregar</button>
                                <button type="button" class="btn btn-primary" id="Modificar_Perfil">Guardar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal fade" id="modal_DetPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                |   <div class="modal-dialog modal-lg" role="document">
                         <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="title-DetPerfil"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            <div class="modal-body">
                                <form action="" id="form_DetPerfil" class="in-line">
                                    <input type="hidden" id="id_perfil">
                                    
                                    <div class="col-12-lg">
                                        <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <span>Perfil: </span>
                                                        <input type="text" class="form-control form-control-sm" id="det_nom_perfil"  onkeyup="this.value = this.value.toUpperCase();" onKeyPress="return soloLetra(event);" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <span>Estado: </span>
                                                        <select name="" id="det_est_perfil" class="form-control form-control-sm" disabled >
                                                        <option value="">Seleccione</option>
                                                        <option value="1">Activo</option>
                                                        <option value="2">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <span>Descripción: </span>
                                                        <input type="text" class="form-control form-control-sm" id="det_desc_perfil"  onkeyup="this.value = this.value.toUpperCase();" onKeyPress="return soloLetra(event);" readonly>
                                                    </div>
                                                </div>
                                                
                                                
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table id="table_DetPerfil" class="table table-centered table-bordered datatable dt-responsive nowrap" data-page-length="5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead class="thead-light">
                                                            <tr>
                                                              
                                                                <th>Modulo</th>
                                                                <th>Opcion del Sitema</th>
                                                                <th>Ver</th>
                                                                <th>Crear</th>
                                                                <th>Editar</th>
                                                                <th>Borrar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                           
                                            
                                        </div>
                                    </div>
                                </form>  
                                
                            </div>
                            <div class="modal-footer">
                              
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            
                            </div>
                        </div>
                    </div>

                </div>
        </div>
        <script src="<?=base_url('public/assets/js/perfiles.js'); ?>"></script>
<?=$this->endSection()?> 

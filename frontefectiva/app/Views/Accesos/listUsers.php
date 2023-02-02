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
                              
                               
                            </div>
                            <div class="row mt-2 d-flex justify-content-between">
                                <div class="col-md-6">
                                   
                                   <a href="<?=base_url('createUser'); ?>" class="float-left btn btn-primary waves-effect waves-light"><i class=" fas fa-plus-circle align-middle ml-2"></i>  Agregar</a>
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
                                                    <?php 
                                                    $count=1;
                                                    foreach ($users as $key => $value) { ?> 
                                                    <tr>
                                                        <td><?=$value->id_us ?> </td>
                                                        <td><?=$count ?> </td>
                                                        <td><?=$value->nombres_us ?> </td>
                                                        <td><?=$value->apepat_us." ".$value->apemat_us ?> </td>
                                                        <td><?=$value->usuario_us ?> </td>
                                                        <td><?=$value->creacion_us ?> </td>
                                                        <td>
                                                            <a href="<?=base_url('modifyUser/'.$value->id_us)?>" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="<?=base_url('deleteUser/'.$value->id_us) ?>" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                                        </td>
                                                    </tr>
                                                    
                                                    <?php $count++; } ?> 
                                                  
                                                  
                                                </tbody>
                                            </table>
                                        </div>
                        </div>
                        </div>
                    </div>
                </div>
        </div>
        <script src="<?=base_url('public/assets/js/listUsers.js'); ?>"></script>
<?=$this->endSection()?> 

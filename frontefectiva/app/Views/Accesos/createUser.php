<?=$this->extend('Layout/main')?> 
<?=$this->section('content');
$session = session();?> 

            <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                <h4 class="card-title">Nuevo Usuario</h4>
                                            </div>
                                            
                                    
                                    </div>
                                    <div class="card-body">
                                    <form  action="<?php echo base_url();?>/main/addUser" method="post">
                       
                                           
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <span>Dni (*):</span>
                                                        <input type="text" id="docident_us" name="docident_us" class="form-control form-control-sm" value=""  onKeyPress="return soloNumero(event);">
                                                        <?php //echo form_error('dni', '<div class="error">', '</div>'); ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <span>Nombres (*):</span>
                                                        <input type="text" id="nombres_us" name="nombres_us" class="form-control form-control-sm" value="" onkeyup="this.value = this.value.toUpperCase();" onKeyPress="return soloLetra(event);">
                                                        <?php //echo form_error('nombres', '<div class="error">', '</div>'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <span>Apellido Paterno (*):</span>
                                                        <input type="text" id="apepat_us" name="apepat_us" class="form-control form-control-sm" value="" onkeyup="this.value = this.value.toUpperCase();" onKeyPress="return soloLetra(event);">
                                                        <?php //echo form_error('apepat', '<div class="error">', '</div>'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <span>Apellido Materno (*):</span>
                                                        <input type="text" id="apemat_us" name="apemat_us" class="form-control form-control-sm" value="" onkeyup="this.value = this.value.toUpperCase();" onKeyPress="return soloLetra(event);">
                                                        <?php //echo form_error('apemat', '<div class="error">', '</div>'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <span>Correo (*):</span>
                                                        <input type="email" id="email_us" name="email_us" class="form-control form-control-sm " value="">
                                                        <?php //echo form_error('email', '<div class="error">', '</div>'); ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <span>Usuario (*):</span>
                                                        <input type="text" id="usuario_us" name="usuario_us" class="form-control form-control-sm" value="" oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/,'')">
                                                        <?php //echo form_error('user', '<div class="error">', '</div>'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <span>Clave (*):</span>
                                                        <div class="form-group">
                                                            <div class="input-group-append">
                                                            <input type="password" id="pass" name="pass" class="form-control form-control-sm" value="">
                                                            
                                                                <button id="show_password" class="btn btn-primary" type="button" title="Mostrar Clave"> <span class="fa fa-eye-slash icon"></span> </button>
                                                            </div>
                                                        </div>
                                                        <?php //echo form_error('pass', '<div class="error">', '</div>'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <div>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                        Guardar
                                                    </button>
                                                    <a href="  <?php echo base_url('listUsers');?>" class="btn btn-danger waves-effect waves-light mr-1">Cancelar</a>
                                                    <?php 
                                                        //echo form_reset(array('value' => 'Cancelar', 'class' => 'btn btn-danger waves-effect waves-light mr-1'));
                                                    ?>   
                                                </div>
                                            </div>
                                     
                                    </form> 
                                    </div>
                                </div>
                            </div> <!-- end col -->
            </div> <!-- end row -->
<?=$this->endSection()?> 
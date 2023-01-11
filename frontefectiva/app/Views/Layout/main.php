
<?=$this->include('Layout/header');

$session = session();?>
    
<body data-sidebar="dark">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                          
                            <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="<?=base_url('public/images/valtx.png') ?>" alt="" height="20" >
                                </span>
                                <span class="logo-lg">
                                    <img src="<?=base_url('public/images/valtx.png') ?>" alt="" height="60" width="150">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn"  style="color:#fff">
                            <i class="ri-menu-2-line align-middle"></i>
                        </button>

                       
                        
                    </div>

                    <div class="d-flex">

                       
                        <div class="dropdown d-inline-block user-dropdown" >
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#fff">
                                <img class="rounded-circle header-profile-user" src="<?=base_url('public/images/avatar_login.png') ?>"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ml-1" ><?=$session->user?></span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a class="dropdown-item" href=""><i class="ri-user-line align-middle mr-1"></i> Perfil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="<?=base_url()?>/logout"><i class="ri-shut-down-line align-middle mr-1 text-danger"></i> Logout</a>
                            </div>
                        </div>

                       
                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                           
                            <li>
                                <a href="<?=base_url('inicio') ?>" class="waves-effect">
                                    <i class=" fas fa-home"></i>
                                    <span>Inicio</span>
                                </a>
                            </li>

                            
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fas fa-list-alt"></i>
                                    <span>Accesos</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">  
                                    <li><a href="<?=base_url('listUsers') ?>">Usuarios</a></li>
                                    <li><a href="<?=base_url('configPass') ?>">Conf. Password</a></li>
                                </ul>
                                
                            </li>
                
                            <li>
                           

                           

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
    <div class="main-content">
          

        <div class="page-content">
            <div class="container-fluid">
            <?=$this->renderSection('content')?>
            </div> <!-- container-fluid -->
        </div>
        <input type="hidden" name="" id="base_url" value=<?=base_url()?>>
        <?=$this->include('Layout/footer')?>
    </div>  
    </body>

</html>
<header class="header-top pt-20" header-theme="dark" style="height: 70px">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button>
            </div>
            <div class="top-menu d-flex align-items-center">
                <?php if($this->router->fetch_class() == 'home' && isset($contador)): ?>
                    <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="blink_me"><i class="ik ik-bell"></i><span class="badge bg-danger"><?php echo $contador; ?></span></span></a>
                    <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
                        <h4 class="header">Notificações</h4>
                        <div class="notifications-wrap">

                            <?php if(isset($mensalidades_vencidas)): ?>

                                <a href="<?php echo base_url('mensalidades'); ?>" class="media">
                                    <span class="d-flex">
                                        <i class="fas fa-hand-holding-usd bg-danger"></i>
                                    </span>
                                    <span class="media-body">
                                        <span class="heading-font-family media-heading">Existem mensalidades vencidas</span> 
                                        <span class="media-content">Verifique o status das mensalidades ...</span>
                                    </span>
                                </a>

                            <?php endif; ?>

                            <?php if(isset($precificacoes_desativadas)): ?>

                                <a href="<?php echo base_url('precificacoes'); ?>" class="media">
                                    <span class="d-flex">
                                        <i class="ik ik-bar-chart-2 bg-warning"></i>
                                    </span>
                                    <span class="media-body">
                                        <span class="heading-font-family media-heading">Existem precificações desativadas</span> 
                                        <span class="media-content">Verifique o status das precificações ...</span>
                                    </span>
                                </a>

                            <?php endif; ?>


                            <?php if(isset($formas_pagamentos_desativadas)): ?>

                                <a href="<?php echo base_url('pagamentos'); ?>" class="media">
                                    <span class="d-flex">
                                        <i class="ik ik-dollar-sign bg-warning"></i>
                                    </span>
                                    <span class="media-body">
                                        <span class="heading-font-family media-heading">Existem formas de pagamento desativadas</span> 
                                        <span class="media-content">Verifique o status das mesmas ...</span>
                                    </span>
                                </a>

                            <?php endif; ?>

                        </div>
                    </div>
                    </div>
                <?php endif;?>

                <button title="Explorar menu" type="button" class="nav-link ml-10" id="apps_modal_btn" data-toggle="modal" data-target="#appsModal"><i class="ik ik-grid"></i></button>
                <div class="dropdown">
                    <a class="dropdown-toggle text-white" href="javascript:void(0);" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php
                        $user = $this->ion_auth->user()->row();
                        echo $user->first_name;
                        ?></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?php echo base_url('usuarios/modulo/' . $user->id); ?>"><i class="ik ik-user dropdown-icon"></i> Meus dados</a>
                        <a class="dropdown-item" href="<?php echo base_url('login/logout'); ?>"><i class="ik ik-power dropdown-icon"></i> Sair</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>

<div class="page-wrap">

<?php $this->load->view('layout/sidebar'); ?>
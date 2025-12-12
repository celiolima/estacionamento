
<div class="main-content">
    <div class="container-fluid">

        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="<?php echo $icone_pagina ?> bg-blue"></i>
                        <h5><?php echo $pagina_atual ?></h5>
                        <span><?php echo $info_pagina_atual; ?></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a title="Home" href="<?php echo base_url('home'); ?>"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $pagina_atual ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?php
        if ($message = $this->session->flashdata('error')):
            ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert bg-danger alert-danger text-white alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span><i class="ik ik-alert-octagon"></i></i>&nbsp;&nbsp;<?php echo $message; ?></span>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <?php
        if ($message = $this->session->flashdata('sucesso')):
            ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert bg-success alert-success text-white alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $message; ?></span>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <div class="row clearfix">

            <div class="col-md-12">

                <div class="card bg-empty">

                    <div class="card-header d-block text-center">
                        <h5>Gostaria de fazer o que?</h5>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col col-md-4 col-6" title="Imprimir ordem de estacionamento">
                                <div class="widget social-widget">
                                    <div class="widget-body">
                                        <div class="icon"><i class="ik ik-printer ik-2x text-success"></i></div>
                                        <div class="content pt-20">
                                            <a title="Imprimir ordem de estacionamento" target="_blank" class="btn btn-success" href="<?php echo base_url('estacionar/pdf/' . $ordem->estacionar_id); ?>">Imprimir Ordem</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col col-md-4 col-6" title="Listar ordens de estacionamento">
                                <div class="widget social-widget">
                                    <div class="widget-body">
                                        <div class="icon"><i class="ik ik-list ik-2x text-dark"></i></div>
                                        <div class="content pt-20">
                                            <a title="Listar ordens de estacionamento" class="btn btn-dark" href="<?php echo base_url('estacionar'); ?>">Listar Ordens</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col col-md-4 col-6" title="Nova ordem de estacionamento">
                                <div class="widget social-widget">
                                    <div class="widget-body">
                                        <div class="icon"><i class="ik ik-file-plus ik-2x text-primary"></i></div>
                                        <div class="content pt-20">
                                            <a title="Nova ordem de estacionamento" class="btn btn-primary" href="<?php echo base_url('estacionar/modulo/'); ?>">Cadastrar Ordem</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
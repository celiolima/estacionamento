<div class="main-content">
    <div class="container-fluid">

        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik <?php echo $icone_pagina ?> bg-blue"></i>
                        <h5><?php echo $pagina_atual ?></h5>
                        <span><?php echo $info_pagina_atual; ?></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $pagina_atual ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?php
        if ($message = $this->session->flashdata('info')):
            ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert bg-info alert-info text-black alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span><i class="ik ik-alert-octagon"></i>&nbsp;&nbsp;<?php echo $message; ?></span>
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

            <!-- project-ticket start -->
                            <div class="col-xl-3 col-md-12">
                                <div class="card proj-t-card">
                                    <div class="card-body text-navy">
                                        <div class="row align-items-center mb-30">
                                            <div class="col-auto">
                                                <i class="fas fa-warehouse text-navy f-30"></i>
                                            </div>
                                            <div class="col pl-0">
                                                <h6 class="mb-5 text-navy f-15">Total vagas</h6>
                                                <h6 class="mb-0 text-navy f-20"><?php echo $numero_total_vagas->total; ?></h6>
                                            </div>
                                        </div>
                                        <div class="row align-items-center text-center">
                                            <div class="col">
                                                <h6 class="mb-0">Livre&nbsp;<span class="badge badge-pill bg-navy text-white"><?php echo $numero_total_vagas->total - $total_estacionados_agora ; ?></span></h6></div>
                                            <div class="col"><i class="fas fa-exchange-alt text-navy f-18"></i></div>
                                            <div class="col">
                                                <h6 class="mb-0">Ocupadas&nbsp;<span class="badge badge-pill bg-navy text-white"><?php echo $total_estacionados_agora; ?></span></h6></div>
                                        </div>
                                        <h6 class="pt-badge bg-navy small">Park Now</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card proj-t-card">
                                    <div class="card-body text-green">
                                        <div class="row align-items-center mb-30">
                                            <div class="col-auto">
                                                <i class="fas fa-hand-holding-usd f-40"></i>
                                            </div>
                                            <div class="col pl-0">
                                                <h6 class="mb-5 f-15">Mensais</h6>
                                                <h6 class="mb-0 text-green f-20"><?php echo 'R$&nbsp;' .$total_mensalidades->total; ?></h6>
                                            </div>
                                        </div>
                                        <div class="row align-items-center text-center">
                                            <div class="col">
                                                <h6 class="mb-0">Pagas <span class="badge badge-pill bg-success text-white"><?php echo $total_mensalidades_receber; ?></span></h6></div>
                                            <div class="col"><i class="fas fa-exchange-alt text-green f-18"></i></div>
                                            <div class="col">
                                                <h6 class="mb-0">Abertas <span class="badge badge-pill bg-success text-white"><?php echo $total_mensalidades_pagas; ?></span></h6></div>
                                        </div>
                                        <h6 class="pt-badge bg-green small">Park Now</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card proj-t-card">
                                    <div class="card-body text-yellow">
                                        <div class="row align-items-center mb-30">
                                            <div class="col-auto">
                                                <i class="fas fa-money-bill-alt f-40"></i>
                                            </div>
                                            <div class="col pl-0">
                                                <h6 class="mb-5 f-15">Avulsos</h6>
                                                <h6 class="mb-0 f-20 "><?php echo 'R$&nbsp;' .$total_avulsos->total; ?></h6>
                                            </div>
                                        </div>
                                        <div class="row align-items-center text-center">
                                            <div class="col">
                                                <h6 class="mb-0">Pagas <span class="badge badge-pill bg-yellow text-dark"><?php echo $total_avulsos_pagos; ?></span></h6></div>
                                            <div class="col"><i class="fas fa-exchange-alt f-18"></i></div>
                                            <div class="col">
                                                <h6 class="mb-0">Abertas <span class="badge badge-pill bg-yellow text-dark"><?php echo $total_avulsos_abertos; ?></span></h6></div>
                                        </div>
                                        <h6 class="pt-badge bg-yellow small text-dark">Park Now</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card proj-t-card">
                                    <div class="card-body text-blue">
                                        <div class="row align-items-center mb-30">
                                            <div class="col-auto">
                                                <i class="fas fa-users f-40"></i>
                                            </div>
                                            <div class="col pl-0">
                                                <h6 class="mb-5 f-15">Mensalistas</h6>
                                                <h6 class="mb-0 f-20"><?php echo $numero_total_mensalistas ?></h6>
                                            </div>
                                        </div>
                                        <div class="row align-items-center text-center">
                                            <div class="col">
                                                <h6 class="mb-0">Ativos <span class="badge badge-pill bg-blue text-white"><?php echo $mensalistas_ativos; ?></span></h6>
                                            </div>
                                            <div class="col"><i class="fas fa-exchange-alt f-18"></i></div>
                                            <div class="col">
                                                <h6 class="mb-0">Inativos <span class="badge badge-pill bg-blue text-white"><?php echo $mensalistas_inativos; ?></span></h6></div>
                                        </div>
                                        <h6 class="pt-badge bg-blue small">Park Now</h6>
                                    </div>
                                </div>
                            </div>
            
        </div>

        <div class="row clearfix">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header d-block text-center">
                        <h5 class="text-uppercase h6">Situação das vagas</h5>
                    </div>

                    <div class="card-body">

                        <div class="row">


                            <div class="col-md-3 mb-35 py-1">
                                <p class="text-center text-uppercase small">Veículo Pequeno<?php echo ($numero_vagas_pequeno->precificacao_ativa == 0 ? '&nbsp;<b><span class="text-danger"><i class="fas fa-ban"></i>&nbsp;Desativada</span></b>' : ''); ?></p>
                                <div class="widget-body text-center">
                                    <div class="content">
                                        <i class="fas fa-car-side fa-3x text-primary"></i>
                                    </div>
                                </div>

                                <div class="">

                                    <ul class="list-inline mt-15 text-center">

                                        <?php $ocupadas = array(); ?>

                                        <?php foreach ($vagas_ocupadas_pequeno as $vaga): ?>

                                            <?php $ocupadas[] = $vaga->estacionar_numero_vaga; ?>
                                            <?php $ocupadas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo; ?>

                                        <?php endforeach; ?>


                                        <?php for ($i = 1; $i <= $numero_vagas_pequeno->vagas; $i++): ?>

                                            <?php if (in_array($i, $ocupadas)): ?>

                                                <li class="list-inline-item">
                                                    <div class="widget social-widget bg-warning vaga">
                                                        <div class="widget-body">
                                                            <div class="content" data-toggle="tooltip" data-placement="top" title="" data-original-title="Placa&nbsp;<?php echo $ocupadas[$i] ?>" title="Ocupada">

                                                                <i class="fas fa-car-side fa-lg"></i>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>


                                            <?php else: ?>

                                                <li class="list-inline-item">
                                                    <div class="widget social-widget <?php echo ($numero_vagas_pequeno->precificacao_ativa == 1 ? 'bg-success' : 'bg-secondary')  ?> vaga">
                                                        <div class="widget-body">
                                                            <div class="content" title="Vaga livre">

                                                                <div title="" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo ($numero_vagas_pequeno->precificacao_ativa == 1 ? 'Vaga livre' : 'Desativada')  ?>" class="text">
                                                                    <?php echo ($numero_vagas_pequeno->precificacao_ativa == 1 ? $i : '<i class="fas fa-ban"></i>')  ?>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>


                                            <?php endif ?>

                                        <?php endfor; ?>
                                    </ul>
                                </div>
                            </div>


                            <div class="col-md-3 mb-35 py-1">
                                <p class="text-center text-uppercase small">Veículo Médio<?php echo ($numero_vagas_medio->precificacao_ativa == 0 ? '&nbsp;<b><span class="text-danger"><i class="fas fa-ban"></i>&nbsp;Desativada</span></b>' : ''); ?></p>
                                <div class="widget-body text-center">
                                    <div class="content">
                                        <i class="fas fa-truck-monster fa-3x text-primary"></i>

                                    </div>
                                </div>

                                <div class="">

                                    <ul class="list-inline mt-15 text-center">

                                        <?php $ocupadas = array(); ?>

                                        <?php foreach ($vagas_ocupadas_medio as $vaga): ?>

                                            <?php $ocupadas[] = $vaga->estacionar_numero_vaga; ?>
                                            <?php $ocupadas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo; ?>

                                        <?php endforeach; ?>


                                        <?php for ($i = 1; $i <= $numero_vagas_medio->vagas; $i++): ?>

                                            <?php if (in_array($i, $ocupadas)): ?>

                                                <li class="list-inline-item">

                                                    <div class="widget social-widget bg-warning vaga">
                                                        <div class="widget-body">
                                                            <div class="content" data-toggle="tooltip" data-placement="top" title="" data-original-title="Placa&nbsp;<?php echo $ocupadas[$i] ?>" title="Ocupada">

                                                                <i class="fas fa-truck-monster fa-lg"></i>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>


                                            <?php else: ?>

                                                <li class="list-inline-item">
                                                    <div class="widget social-widget <?php echo ($numero_vagas_medio->precificacao_ativa == 1 ? 'bg-success' : 'bg-secondary')  ?> vaga">
                                                        <div class="widget-body">
                                                            <div class="content" title="Vaga livre">

                                                                <div title="" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo ($numero_vagas_medio->precificacao_ativa == 1 ? 'Vaga livre' : 'Desativada')  ?>" class="text">
                                                                    <?php echo ($numero_vagas_medio->precificacao_ativa == 1 ? $i : '<i class="fas fa-ban"></i>')  ?>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>


                                            <?php endif ?>

                                        <?php endfor; ?>
                                    </ul>
                                </div>
                            </div>


                            <div class="col-md-3 mb-35 py-1">
                                <p class="text-center text-uppercase small">Veículo Grande<?php echo ($numero_vagas_grande->precificacao_ativa == 0 ? '&nbsp;<b><span class="text-danger"><i class="fas fa-ban"></i>&nbsp;Desativada</span></b>' : ''); ?></p>
                                <div class="widget-body text-center">
                                    <div class="content">
                                        <i class="fas fa-truck fa-3x text-primary"></i>
                                    </div>
                                </div>

                                <div class="">

                                    <ul class="list-inline mt-15 text-center">

                                        <?php $ocupadas = array(); ?>

                                        <?php foreach ($vagas_ocupadas_grande as $vaga): ?>

                                            <?php $ocupadas[] = $vaga->estacionar_numero_vaga; ?>
                                            <?php $ocupadas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo; ?>

                                        <?php endforeach; ?>


                                        <?php for ($i = 1; $i <= $numero_vagas_grande->vagas; $i++): ?>

                                            <?php if (in_array($i, $ocupadas)): ?>

                                                <li class="list-inline-item">
                                                    <div class="widget social-widget bg-warning vaga">
                                                        <div class="widget-body">
                                                            <div class="content" data-toggle="tooltip" data-placement="top" title="" data-original-title="Placa&nbsp;<?php echo $ocupadas[$i] ?>" title="Ocupada">

                                                                <i class="fas fa-truck fa-lg"></i>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>


                                            <?php else: ?>

                                                <li class="list-inline-item">
                                                    <div class="widget social-widget <?php echo ($numero_vagas_grande->precificacao_ativa == 1 ? 'bg-success' : 'bg-secondary')  ?> vaga">
                                                        <div class="widget-body">
                                                            <div class="content" title="Vaga livre">

                                                                <div title="" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo ($numero_vagas_grande->precificacao_ativa == 1 ? 'Vaga livre' : 'Desativada')  ?>" class="text">
                                                                    <?php echo ($numero_vagas_grande->precificacao_ativa == 1 ? $i : '<i class="fas fa-ban"></i>')  ?>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>


                                            <?php endif ?>

                                        <?php endfor; ?>
                                    </ul>
                                </div>
                            </div>


                            <div class="col-md-3 mb-35 py-1">
                                <p class="text-center text-uppercase small">Veículo Moto<?php echo ($numero_vagas_moto->precificacao_ativa == 0 ? '&nbsp;<b><span class="text-danger"><i class="fas fa-ban"></i>&nbsp;Desativada</span></b>' : ''); ?></p>
                                <div class="widget-body text-center">
                                    <div class="content">
                                        <i class="fas fa-motorcycle fa-3x text-primary"></i>
                                    </div>
                                </div>

                                <div class="">

                                    <ul class="list-inline mt-15 text-center">

                                        <?php $ocupadas = array(); ?>

                                        <?php foreach ($vagas_ocupadas_moto as $vaga): ?>

                                            <?php $ocupadas[] = $vaga->estacionar_numero_vaga; ?>
                                            <?php $ocupadas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo; ?>


                                        <?php endforeach; ?>

                                        <?php
                                        //echo '<pre>';
                                        //print_r($ocupadas);
                                        ?>


                                        <?php for ($i = 1; $i <= $numero_vagas_moto->vagas; $i++): ?>

                                            <?php if (in_array($i, $ocupadas)): ?>

                                                <li class="list-inline-item">
                                                    <div class="widget social-widget bg-warning vaga">
                                                        <div class="widget-body">
                                                            <div class="content" data-toggle="tooltip" data-placement="top" title="" data-original-title="Placa&nbsp;<?php echo $ocupadas[$i] ?>" title="Ocupada">

                                                                <i class="fas fa-motorcycle fa-lg"></i>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>


                                            <?php else: ?>

                                                <li class="list-inline-item">
                                                    <div class="widget social-widget <?php echo ($numero_vagas_moto->precificacao_ativa == 1 ? 'bg-success' : 'bg-secondary')  ?> vaga">
                                                        <div class="widget-body">
                                                            <div class="content" title="Vaga livre">

                                                                <div title="" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo ($numero_vagas_moto->precificacao_ativa == 1 ? 'Vaga livre' : 'Desativada')  ?>" class="text">
                                                                    <?php echo ($numero_vagas_moto->precificacao_ativa == 1 ? $i : '<i class="fas fa-ban"></i>')  ?>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                            <?php endif ?>

                                        <?php endfor; ?>
                                    </ul>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


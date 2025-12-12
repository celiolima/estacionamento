
<div class="main-content">
    <div class="container-fluid">

        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="<?php echo $icone_pagina ?> bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $pagina_atual ?></h5>
                            <span><?php echo $info_pagina_atual; ?></span>
                        </div>
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

                <div class="card">

                    <div class="card-header d-block">
                        <a title="Nova mensalidade" href="<?php echo base_url('mensalidades/modulo'); ?>" class="btn bg-blue btn-rounded float-right text-white"><i class="ik ik-plus ik-1x"></i>Nova</a>                        
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-borderless nowrap table-sm display dt-responsive nowrap compact py-3" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="all">Nome</th>                                
                                        <th class="all">CPF / CNPJ</th>      
                                        <th class="">Categoria</th>
                                        <th class="">Valor</th>
                                        <th class="">Dia vencimento</th>
                                        <th class="">Data vencimento</th>
                                        <th class="">Data pagamento</th>
                                        <th class="all text-center">Status</th>
                                        <th class="all no-sort text-right">Ações</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($mensalidades as $mensalidade): ?>
                                        <tr>
                                            <td><?php echo $mensalidade->mensalidade_id ?></td>
                                            <td class="pr-20"><a title="Visualizar mensalista" class="btn btn-sm btn-link" href="<?php echo base_url('mensalistas/modulo/' . $mensalidade->mensalista_id); ?>"><i class="ik ik-eye"></i><?php echo $mensalidade->mensalista_nome; ?></a></td>
                                            <td><?php echo $mensalidade->mensalista_cpf_cnpj; ?></td>
                                            <td><?php echo $mensalidade->mensalista_categoria; ?></td>
                                            <td><?php echo $mensalidade->mensalista_valor_mensalidade; ?></td>

                                            <td><?php echo $mensalidade->mensalista_dia_vencimento; ?></td>
                                            <td><?php echo formata_data_banco_sem_hora($mensalidade->mensalidade_data_vencimento); ?></td>
                                            <td><?php echo ($mensalidade->mensalidade_status == 1 ? formata_data_banco_com_hora($mensalidade->mensalidade_data_pagamento) : 'Open'); ?></td>

                                            <td class="text-center pr-4">
                                            <?php
                                            if ($mensalidade->mensalidade_status == 1) {
                                                echo '<span class="badge badge-pill badge-success small">Paga</span>';
                                            } else if (strtotime($mensalidade->mensalidade_data_vencimento) > strtotime(date('Y-m-d'))) {
                                                echo '<span class="badge badge-pill badge-primary small">A receber</span>';
                                            } else if (strtotime($mensalidade->mensalidade_data_vencimento) == strtotime(date('Y-m-d'))) {
                                                echo '<span class="badge badge-pill badge-navy text-white">Vence hoje</span>';
                                            } else {
                                                echo '<span class="badge badge-pill badge-danger">Vencida</span>';
                                            }
                                            ?>
                                            </td>


                                            <!--<td class="text-center pr-15"><?php echo ($mensalidade->mensalidade_status == 1 ? '<span class="badge badge-pill badge-success small">Paga</span>' : '<span class="badge badge-pill badge-danger">Open</span>') ?><?php echo $info; ?></td>-->

                                            <td class="text-right">
                                                <?php if($mensalidade->mensalidade_status == 0): ?>

                                                    <a title="Editar mensalidade" href="<?php echo base_url('mensalidades/modulo/' . $mensalidade->mensalidade_id); ?>" class="btn btn-icon btn-primary mr-2"><i class="ik ik-edit"></i></a>

                                                <?php else: ?>

                                                    <a title="Visualizar mensalidade" href="<?php echo base_url('mensalidades/modulo/' . $mensalidade->mensalidade_id); ?>" class="btn btn-icon btn-success mr-2"><i class="ik ik-eye text-white"></i></a>

                                                <?php endif ?>
                                                <a title="Excluir mensalidade" href="javascript:void(0)" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#mensalidade-<?php echo $mensalidade->mensalidade_id; ?>" ><i class="ik ik-trash-2"></i></a>
                                            </td>
                                        </tr>

                                    <div class="modal fade" id="mensalidade-<?php echo $mensalidade->mensalidade_id; ?>" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="demoModalLabel"><i class="ik ik-alert-octagon text-danger"></i>&nbsp;&nbsp;Exclusão de registro!</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    Clique em <span class="text-danger font-weight-bold">"Sim"</span> se você deseja excluir o registro.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                                                    <a href="<?php echo base_url('mensalidades/del/' . $mensalidade->mensalidade_id); ?>" type="button" class="btn btn-danger">Sim</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
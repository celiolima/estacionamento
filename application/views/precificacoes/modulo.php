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
                            <li class="breadcrumb-item">
                                <a title="Home" href="<?php echo base_url('home'); ?>"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a title="Precificações" href="<?php echo base_url('precificacoes'); ?>">Precificações</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $pagina_atual ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?php
        /* Utilizado para situações de ações não permitadas */
        if ($message = $this->session->flashdata('error')):
            ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert bg-danger alert-danger text-white alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" style="color: black !important">&times;</button>
                        <span><i class="fas fa-skull-crossbones"></i>&nbsp;&nbsp;<?php echo $message; ?></span>
                    </div>
                </div>
            </div>

        <?php endif; ?>



        <div class="row">

            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h3><?php echo $titulo; ?></h3>
                    </div>
                    <div class="card-body">

                        <?php if (isset($precificacao)): ?>

                            <p class="text-muted small mb-4"><i class="ik ik-edit-1 ik-2x">&nbsp;&nbsp;</i>Última atualização:&nbsp;&nbsp;</i><?php echo formata_data_banco_com_hora($precificacao->precificacao_data_alteracao); ?></p>

                        <?php endif; ?>

                        <form class="forms-sample" name="form_modulo" method="post">

                            <div class="row mb-3">

                                <div class="col-md-4 mb-3">
                                    <label for="">Categoria</label>
                                    <input type="text" class="form-control" name="precificacao_categoria" value="<?php echo (isset($precificacao) ? $precificacao->precificacao_categoria : set_value('precificacao_categoria')) ?>">
                                    <?php echo form_error('precificacao_categoria', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-2">
                                    <label for="">Valor hora</label>
                                    <input type="text" class="form-control money" name="precificacao_valor_hora" value="<?php echo (isset($precificacao) ? $precificacao->precificacao_valor_hora : set_value('precificacao_valor_hora')) ?>">
                                    <?php echo form_error('precificacao_valor_hora', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-2">
                                    <label for="">Valor mensalidade</label>
                                    <input type="text" class="form-control money" name="precificacao_valor_mensalidade" value="<?php echo (isset($precificacao) ? $precificacao->precificacao_valor_mensalidade : set_value('precificacao_valor_mensalidade')) ?>">
                                    <?php echo form_error('precificacao_valor_mensalidade', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-2">
                                    <label for="">Número de vagas</label>
                                    <input type="number" class="form-control" name="precificacao_numero_vagas" value="<?php echo (isset($precificacao) ? $precificacao->precificacao_numero_vagas : set_value('precificacao_numero_vagas')) ?>">
                                    <?php echo form_error('precificacao_numero_vagas', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-2">
                                    <label for="">Ativa</label>
                                    <select class="form-control" name="precificacao_ativa">
                                        <?php if (isset($precificacao)): ?>

                                            <option value="0" <?php echo ($precificacao->precificacao_ativa == 0 ? 'selected' : '') ?>>Não</option>
                                            <option value="1" <?php echo ($precificacao->precificacao_ativa == 1 ? 'selected' : '') ?>>Sim</option>

                                        <?php else: ?>

                                            <option value="0">Não</option>
                                            <option value="1">Sim</option>

                                        <?php endif; ?>

                                    </select>

                                </div>

                            </div>


                            <?php if (isset($precificacao)): ?>
                                <input type="hidden" name="precificacao_id" value="<?php echo $precificacao->precificacao_id ?>"/>
                            <?php endif; ?>


                            <button type="submit" class="btn btn-primary mr-2" value="<?php echo $valor_btn ?>"><?php echo $valor_btn ?></button>

                            <a href="<?php echo base_url($this->router->fetch_class()); ?>" class="btn btn-light">Voltar</a>

                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>



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
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $pagina_atual ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?php
        /* Utilizado para situações de erro */
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


        <div class="row">

            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h3><?php echo $titulo; ?></h3>
                    </div>
                    <div class="card-body">

                        <?php if (isset($sistema)): ?>

                            <p class="text-muted small mb-4"><i class="ik ik-edit-1 ik-2x">&nbsp;&nbsp;</i>Última atualização:&nbsp;&nbsp;</i><?php echo formata_data_banco_com_hora($sistema->sistema_data_alteracao); ?></p>

                        <?php endif; ?>

                        <form class="forms-sample" name="form_index" method="post">

                            <div class="row mb-3">

                                <div class="col-md-6 mb-3">
                                    <label for="">Razão social</label>
                                    <input type="text" class="form-control" name="sistema_razao_social" value="<?php echo ($sistema->sistema_razao_social) ?>">
                                    <?php echo form_error('sistema_razao_social', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-6">
                                    <label for="">Nome fantasia</label>
                                    <input type="text" class="form-control" name="sistema_nome_fantasia" value="<?php echo ($sistema->sistema_nome_fantasia) ?>">
                                    <?php echo form_error('sistema_nome_fantasia', '<div class="text-danger">', '</div>') ?>
                                </div>

                            </div>

                            <div class="row mb-3">

                                <div class="col-md-3 mb-3">
                                    <label for="">CNPJ</label>
                                    <input type="text" class="form-control cnpj" name="sistema_cnpj" value="<?php echo ($sistema->sistema_cnpj) ?>">
                                    <?php echo form_error('sistema_cnpj', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="">Inscrição estadual</label>
                                    <input type="text" class="form-control" name="sistema_ie" value="<?php echo ($sistema->sistema_ie) ?>">
                                    <?php echo form_error('sistema_ie', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="">Telefone fixo</label>
                                    <input type="text" class="form-control phone_with_ddd" name="sistema_telefone_fixo" value="<?php echo ($sistema->sistema_telefone_fixo) ?>">
                                    <?php echo form_error('sistema_telefone_fixo', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="">Telefone móvel</label>
                                    <input type="text" class="form-control phone_with_ddd" name="sistema_telefone_movel" value="<?php echo ($sistema->sistema_telefone_movel) ?>">
                                    <?php echo form_error('sistema_telefone_movel', '<div class="text-danger">', '</div>') ?>
                                </div>

                            </div>

                            <div class="row mb-3">

                                <div class="col-md-2 mb-3">
                                    <label for="">CEP</label>
                                    <input type="text" class="form-control cep" name="sistema_cep" value="<?php echo ($sistema->sistema_cep) ?>">
                                    <?php echo form_error('sistema_cep', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="">Endereço</label>
                                    <input type="text" class="form-control" name="sistema_endereco" value="<?php echo ($sistema->sistema_endereco) ?>">
                                    <?php echo form_error('sistema_endereco', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="">Número</label>
                                    <input type="text" class="form-control" name="sistema_numero" value="<?php echo ($sistema->sistema_numero) ?>">
                                    <?php echo form_error('sistema_numero', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="">Cidade</label>
                                    <input type="text" class="form-control" name="sistema_cidade" value="<?php echo ($sistema->sistema_cidade) ?>">
                                    <?php echo form_error('sistema_cidade', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="">Estado</label>
                                    <input type="text" class="form-control uf" name="sistema_estado" value="<?php echo ($sistema->sistema_estado) ?>">
                                    <?php echo form_error('sistema_estado', '<div class="text-danger">', '</div>') ?>
                                </div>

                            </div>

                            <div class="row mb-3">

                                <div class="col-md-6 mb-3">
                                    <label for="">URL do site</label>
                                    <input type="url" class="form-control" name="sistema_site_url" value="<?php echo ($sistema->sistema_site_url) ?>">
                                    <?php echo form_error('sistema_site_url', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="">E-mail</label>
                                    <input type="email" class="form-control" name="sistema_email" value="<?php echo ($sistema->sistema_email) ?>">
                                    <?php echo form_error('sistema_email', '<div class="text-danger">', '</div>') ?>
                                </div>

                            </div>


                            <div class="row mb-3">

                                <div class="col-md-12 mb-3">
                                    <label for="">Texto da ordem de serviço</label>
                                    <textarea name="sistema_txt_ordem_servico" rows="3" class="form-control"><?php echo ($sistema->sistema_txt_ordem_servico) ?></textarea>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Atualizar</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>



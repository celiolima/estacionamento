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
                            <li class="breadcrumb-item">
                                <a title="Mensalistas" href="<?php echo base_url($this->router->fetch_class()); ?>">Mensalistas</a>
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

                        <?php if (isset($mensalista)): ?>

                            <p class="text-muted small mb-4"><i class="ik ik-edit-1 ik-2x">&nbsp;&nbsp;</i>Última atualização:&nbsp;&nbsp;</i><?php echo formata_data_banco_com_hora($mensalista->mensalista_data_alteracao); ?></p>

                        <?php endif; ?>



                        <form class="forms-sample" name="form_modulo" method="post">



                            <div class="row mb-3">

                                <div class="col-md-12 mb-30">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <?php if (isset($mensalista)): ?>
                                            <input type="radio" id="pessoa_fisica" name="mensalista_tipo" class="custom-control-input" value="1" <?php echo set_checkbox('mensalista_tipo', '1') ?> <?php echo (isset($mensalista) && $mensalista->mensalista_tipo == 1 ? 'checked' : ''); ?>>
                                        <?php else: ?>
                                            <input type="radio" id="pessoa_fisica" name="mensalista_tipo" class="custom-control-input" value="1" <?php echo set_checkbox('mensalista_tipo', '1') ?> checked="">
                                        <?php endif; ?>
                                        <label class="custom-control-label" for="pessoa_fisica">Pessoa física</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <?php if (isset($mensalista)): ?>
                                            <input type="radio" id="pessoa_juridica" name="mensalista_tipo" class="custom-control-input" value="2" <?php echo set_checkbox('mensalista_tipo', '2') ?> <?php echo (isset($mensalista) && $mensalista->mensalista_tipo == 2 ? 'checked' : ''); ?>>
                                        <?php else: ?>
                                            <input type="radio" id="pessoa_juridica" name="mensalista_tipo" class="custom-control-input" value="2" <?php echo set_checkbox('mensalista_tipo', '2') ?>>
                                        <?php endif; ?>
                                        <label class="custom-control-label" for="pessoa_juridica">Pessoa jurídica</label>
                                    </div>
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label for="">Nome</label>
                                    <input type="text" class="form-control" name="mensalista_nome" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_nome : set_value('mensalista_nome')) ?>">
                                    <?php echo form_error('mensalista_nome', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label for="">Sobrenome</label>
                                    <input type="text" class="form-control" name="mensalista_sobrenome" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_sobrenome : set_value('mensalista_sobrenome')) ?>">
                                    <?php echo form_error('mensalista_sobrenome', '<div class="text-danger">', '</div>') ?>
                                </div>

                            </div>

                            <div class="row mb-3">

                                <div class="col-md-2 mb-3">
                                    <label for="">Data nascimento</label>
                                    <input type="date" class="form-control" name="mensalista_data_nascimento" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_data_nascimento : set_value('mensalista_data_nascimento')) ?>">
                                    <?php echo form_error('mensalista_data_nascimento', '<div class="text-danger">', '</div>') ?>
                                </div>

                                <div class="col-md-2 mb-3">

                                    <div class="pessoa_fisica">
                                        <label for="">CPF</label>
                                        <input type="text" class="form-control cpf" name="mensalista_cpf" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_cpf_cnpj : set_value('mensalista_cpf')) ?>">
                                        <?php echo form_error('mensalista_cpf', '<div class="text-danger">', '</div>') ?>
                                    </div>

                                    <div class="pessoa_juridica">
                                        <label for="">CNPJ</label>
                                        <input type="text" class="form-control cnpj" name="mensalista_cnpj" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_cpf_cnpj : set_value('mensalista_cnpj')) ?>">
                                        <?php echo form_error('mensalista_cnpj', '<div class="text-danger">', '</div>') ?>
                                    </div>

                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label class="pessoa_fisica">RG</label>
                                        <label class="pessoa_juridica">I.E</label>
                                        <input type="text" class="form-control" name="mensalista_rg_ie" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_rg_ie : set_value('mensalista_rg_ie')) ?>">
                                        <?php echo form_error('mensalista_rg_ie', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="">E-mail</label>
                                        <input type="email" class="form-control" name="mensalista_email" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_email : set_value('mensalista_email')) ?>">
                                        <?php echo form_error('mensalista_email', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <label for="">Telefone fixo</label>
                                        <input type="text" class="form-control phone_with_ddd" name="mensalista_telefone_fixo" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_telefone_fixo : set_value('mensalista_telefone_fixo')) ?>">
                                        <?php echo form_error('mensalista_telefone_fixo', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <label for="">Telefone móvel</label>
                                        <input type="text" class="form-control phone_with_ddd" name="mensalista_telefone_movel" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_telefone_movel : set_value('mensalista_telefone_movel')) ?>">
                                        <?php echo form_error('mensalista_telefone_movel', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <label for="">CEP</label>
                                        <input type="text" class="form-control cep" name="mensalista_cep" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_cep : set_value('mensalista_cep')) ?>">
                                        <?php echo form_error('mensalista_cep', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="">Endereço</label>
                                        <input type="text" class="form-control" name="mensalista_endereco" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_endereco : set_value('mensalista_endereco')) ?>">
                                        <?php echo form_error('mensalista_endereco', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <label for="">Número</label>
                                        <input type="text" class="form-control" name="mensalista_numero_endereco" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_numero_endereco : set_value('mensalista_numero_endereco')) ?>">
                                        <?php echo form_error('mensalista_numero_endereco', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>


                            </div>

                            <div class="row">

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="">Bairro</label>
                                        <input type="text" class="form-control" name="mensalista_bairro" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_bairro : set_value('mensalista_bairro')) ?>">
                                        <?php echo form_error('mensalista_bairro', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="">Cidade</label>
                                        <input type="text" class="form-control" name="mensalista_cidade" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_cidade : set_value('mensalista_cidade')) ?>">
                                        <?php echo form_error('mensalista_cidade', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <label for="">UF</label>
                                        <input type="text" class="form-control uf" name="mensalista_estado" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_estado : set_value('mensalista_estado')) ?>">
                                        <?php echo form_error('mensalista_estado', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="">Complemento</label>
                                        <input type="text" class="form-control" name="mensalista_complemento" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_complemento : set_value('mensalista_complemento')) ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Ativo</label>
                                        <select class="form-control" name="mensalista_ativo">
                                            <?php if (isset($mensalista)): ?>

                                                <option value="0" <?php echo ($mensalista->mensalista_ativo == 0 ? 'selected' : ''); ?>>Não</option>
                                                <option value="1" <?php echo ($mensalista->mensalista_ativo == 1 ? 'selected' : '') ?>>Sim</option>

                                            <?php else: ?>

                                                <option value="0">Não</option>
                                                <option value="1">Sim</option>

                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Dia vencimento mensalidade</label>
                                        <input type="text" class="form-control dia_vencimento" name="mensalista_dia_vencimento" value="<?php echo (isset($mensalista) ? $mensalista->mensalista_dia_vencimento : set_value('mensalista_dia_vencimento')) ?>">
                                        <?php echo form_error('mensalista_dia_vencimento', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Observações</label>

                                        <textarea class="form-control" rows="1" name="mensalista_obs"><?php echo (isset($mensalista) ? $mensalista->mensalista_obs : set_value('mensalista_obs')) ?></textarea>

                                    </div>
                                </div>

                            </div>


                            <?php if (isset($mensalista)): ?>
                                <input type="hidden" name="mensalista_id" value="<?php echo $mensalista->mensalista_id ?>"/>
                            <?php endif; ?>


                            <button type="submit" class="btn btn-primary mr-2"><?php echo $valor_btn ?></button>

                            <a href="<?php echo base_url($this->router->fetch_class()); ?>" class="btn btn-light">Voltar</a>

                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>



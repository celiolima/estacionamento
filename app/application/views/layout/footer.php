<footer class="footer text-center">
    <div class="w-100 clearfix">
        <span class="text-center text-sm-left d-md-inline-block">Copyright © <?php echo date('Y') ?> STE SISTEMAS All Rights Reserved</span>
        <span class="mt-1 mt-sm-0 text-center"> | Customizado <i class="fas fa-chalkboard-teacher text-danger"></i> por <a href="javascript:void(0)" class="text-dark">Celio Lima</a></span>
    </div>
</footer>

</div>
<!--</div>-->


<div class="modal fade apps-modal" id="appsModal" tabindex="-1" role="dialog" aria-labelledby="appsModalLabel" aria-hidden="true" data-backdrop="false">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ik ik-x-circle"></i></button>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="quick-search">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 ml-auto mr-auto">
                            <div class="input-wrap">
                                <input type="text" id="quick-search" class="form-control" placeholder="Procurar..." />
                                <i class="ik ik-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="container">
                    <div class="apps-wrap">
                        <div class="app-item">
                            <a title="Home" href="<?php echo base_url('/'); ?>"><i class="ik ik-home"></i><span>Home</span></a>
                        </div>
                        <div class="app-item">
                            <a title="Estacionar" href="<?php echo base_url('estacionar'); ?>"><i class="fas fa-parking"></i><span>Estacionar</span></a>
                        </div>
                        <div class="app-item">
                            <a title="Mensalistas" href="<?php echo base_url('Mensalistas'); ?>"><i class="fas fa-users"></i><span>Mensalistas</span></a>
                        </div>
                        <?php if ($this->ion_auth->is_admin()): ?>

                            <div class="app-item">
                                <a title="Mensalidades" href="<?php echo base_url('mensalidades'); ?>"><i class="fas fa-file-invoice-dollar"></i><span>Mensalidades</span></a>
                            </div>
                            <div class="app-item">
                                <a title="Precificação" href="<?php echo base_url('precificacao'); ?>"><i class="fas fa-funnel-dollar"></i><span>Precificação</span></a>
                            </div>
                            <div class="app-item">
                                <a title="Formas de pagamento" href="<?php echo base_url('pagamentos'); ?>"><i class="fas fa-money-bill-alt"></i><span>Formas de pagamento</span></a>
                            </div>
                            <div class="app-item">
                                <a href="<?php echo base_url('sistema'); ?>"><i class="ik ik-settings"></i><span>Sistema</span></a>
                            </div>
                            <div class="app-item">
                                <a href="<?php echo base_url('usuarios'); ?>"><i class="ik ik-users"></i><span>Usuários</span></a>
                            </div>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('public/src/js/vendor/modernizr-2.8.3.min.js'); ?>"></script>
<script src="<?php echo base_url('public/src/js/vendor/jquery-3.3.1.min.js'); ?>"></script>
<script src="<?php echo base_url('public/plugins/popper.js/dist/umd/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('public/plugins/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('public/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js'); ?>"></script>
<script src="<?php echo base_url('public/plugins/screenfull/dist/screenfull.js'); ?>"></script>


<?php if (isset($scripts)): ?>

    <?php foreach ($scripts as $script): ?>
        <script src="<?php echo base_url('public/' . $script); ?>"></script>
    <?php endforeach; ?>

<?php endif; ?>


<script src="<?php echo base_url('public/dist/js/theme.min.js'); ?>"></script>
<script src="<?php echo base_url('public/dist/js/util.js'); ?>"></script>
</body>

</html>
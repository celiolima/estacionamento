<div class="app-sidebar colored">
    <div class="sidebar-header" style="height: 70px">
        <a title="Home" class="header-brand" href="<?php echo base_url('home'); ?>">
            <div class="logo-img">
                <img src="<?php echo base_url('public/src/img/logo.png'); ?>" width="55" class="" alt="Logo park now" style="margin-left: -13px !important;">
            </div>
            <span class="text pl-15">STE Park</span>
        </a>
        <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-lavel">Parking</div>
                <div class="nav-item active">
                    <a title="Home" href="<?php echo base_url('home'); ?>"><i class="ik ik-home"></i><span>Home</span></a>
                </div>
                <div class="nav-item">
                    <a title="Estacionar" href="<?php echo base_url('estacionar'); ?>"><i class="fas fa-parking"></i><span>Estacionar</span></a>
                </div>
                <div class="nav-item">
                    <a title="Listar mensalistas" href="<?php echo base_url('mensalistas'); ?>"><i class="fas fa-users"></i><span>Mensalistas</span></a>
                </div>

                <?php if ($this->ion_auth->is_admin()): ?>

                    <div class="nav-item">
                        <a title="Gerenciar mensalidades" href="<?php echo base_url('mensalidades'); ?>"><i class="fas fa-hand-holding-usd"></i><span>Mensalidades</span></a>
                    </div>

                    <div class="nav-lavel">Administração</div>
                    <div class="nav-item">
                        <a title="Listar usuários" href="<?php echo base_url('usuarios'); ?>"><i class="ik ik-users"></i><span>Usuários</span></a>
                    </div>
                    <div class="nav-item">
                        <a title="Gerenciar configurações do sistema" href="<?php echo base_url('sistema'); ?>"><i class="ik ik-settings"></i><span>Sistema</span></a>
                    </div>
                    <div class="nav-item">
                        <a title="Gerenciar preços e categorias" href="<?php echo base_url('precificacoes'); ?>"><i class="fas fa-file-invoice-dollar"></i><span>Precificação</span></a>
                    </div>
                    <div class="nav-item">
                        <a title="Gerenciar formas de pagamento" href="<?php echo base_url('pagamentos'); ?>"><i class="fas fa-money-bill-alt"></i><span>Forma de pagamento</span></a>
                    </div>

                <?php endif; ?>

            </nav>
        </div>
    </div>
</div>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <?php if (isset($titulo)): ?>
            <title><?php echo 'System Park |&nbsp;' . $titulo ?></title>
        <?php else: ?>
            <title>Park Now | Seu veículo em boas mão</title>
        <?php endif; ?>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="<?php echo base_url('public/src/img/favicon.ico'); ?>" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

        <link rel="stylesheet" href="<?php echo base_url('public/plugins/bootstrap/dist/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('public/plugins/icon-kit/dist/css/iconkit.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('public/dist/css/theme.min.css'); ?>">

        <style type="text/css">
            .auth-wrapper .authentication-form .logo-centered {
                width: 210px;

            }
        </style>

    </head>

    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="auth-wrapper">
            <div class="container-fluid h-100">
                <div class="row flex-row h-100 bg-white">
                    <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
                        <div class="lavalite-bg" style="background-image: url('<?php echo base_url('public/img/auth/login2-opt.jpg'); ?>')">
                            <div class="lavalite-overlay"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                        <div class="authentication-form mx-auto">

                            <?php
                            /* Utilizado para situações de ações não permitadas */
                            if ($message = $this->session->flashdata('error')):
                                ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert bg-danger alert-danger text-white alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" style="color: black !important">&times;</button>
                                            <span><i class="ik ik-alert-octagon"></i>&nbsp;&nbsp;<?php echo $message; ?></span>
                                        </div>
                                    </div>
                                </div>

                            <?php endif; ?>

                            <div class="logo-centered">
                                <a href="<?php echo base_url('/'); ?>"><img src="<?php echo base_url('public/src/img/logo.png'); ?>" alt=""></a>
                            </div>
                            <h3>Entrar no Park Now</h3>
                            <p>Estamos felizes em ver você!</p>
                            <form name="form_auth" method="post" action="<?php echo base_url('login/auth'); ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="email" placeholder="E-mail" required="">
                                    <i class="ik ik-user"></i>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="senha" placeholder="Senha" required="">
                                    <i class="ik ik-lock"></i>
                                </div>

                                <div class="sign-btn text-center">
                                    <button class="btn btn-theme">Entrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('public/src/js/vendor/jquery-3.3.1.min.js'); ?>"></script>
        <script src="<?php echo base_url('public/plugins/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
    </body>
</html>

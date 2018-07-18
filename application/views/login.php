<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Controle de Acesso | </title>

    <!-- Bootstrap -->
    <link href="<?= base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url(); ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url(); ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?= base_url(); ?>assets/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= base_url(); ?>assets/build/css/custom.min.css" rel="stylesheet">

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url(); ?>assets/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url(); ?>assets/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url(); ?>assets/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url(); ?>assets/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url(); ?>assets/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url(); ?>assets/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url(); ?>assets/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url(); ?>assets/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>assets/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?= base_url(); ?>assets/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url(); ?>assets/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url(); ?>assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= base_url(); ?>assets/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

  </head>

  <body class="login" style="background-color: white;" >
    <div>
      
      <div class="login_wrapper">
        
        <div class="animate form login_form">
          <section class="login_content">
          <div>
          <img width="320" src="<?= base_url(); ?>assets/images/maxpay_logo-02.png">
          </div>

            <form method="post" action="<?= base_url(); ?>login/autenticar">
              <h1>Controle de Acesso</h1>
              <?php if ($error = $this->session->flashdata('alerta')): ?>
                  <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong><?= $this->session->flashdata('alerta'); ?></strong>
                  </div>
              <?php endif; ?>
              <div>
                <input type="text" class="form-control" name="email" placeholder="E-mail" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="senha" placeholder="Senha" required="" />
              </div>
              <div>
                <button type="submit" class="col-md-12 btn btn-warning">Entrar</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Esqueceu a senha?
                  <a href=""> Clique aqui! </a>
                </p>

                <div class="clearfix"></div>

                <div>
                  <p>©2018 Todos os Direitos Reservado. Masterpay! Sua forma de pagamento inteligente</p>
                </div>
              </div>
            </form>
          </section>
        </div>
        </div>
      </div>
    </div>
  </body>
</html>
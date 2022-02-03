<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" id="bootstrap-css">
  <link href="<?php echo base_url('public/css/sig-in.css') ?>" rel="stylesheet" id="bootstrap-css">
  <script src="<?php echo base_url('public/bootstrap/js/bootstrap.min.js') ?>"></script>
  <script src="<?php echo base_url('public/js/jquery-3.6.0.min.js') ?>"></script>
  
  <script>

$(document).ready( function(){
  setTimeout(function () {
              $(".alert").fadeOut("fast");
            
       }, 10000);
});
    
    </script>

</head>

<body class="text-center">

  <?php

  $validation = \Config\Services::validation();

  ?>

  <form action="<?php echo base_url('/auth/resetar_senha_validation') ?>" method="post" class="form-signin">
    <?php csrf_field(); ?>
    <h1 class="h3 mb-3 font-weight-normal">Cadastro de nova senha</h1>
    <hr />
    <?php
    $session = \Config\Services::session();

    if ($session->getFlashdata('fail')) {
      echo '
        <div class="alert alert-danger">' . $session->getFlashdata("fail") . '</div>
        ';
    }

    if ($session->getFlashdata('success')) {
      echo '
        <div class="alert alert-success">' . $session->getFlashdata("success") . '</div>
        ';
    }
    ?>
    <div class="form-group">
      <label class="sr-only">Nova Senha</label>
      <input name="nova_senha" type="text" class="form-control" placeholder="Digite a nova senha" value="<?= set_value('nova_senha'); ?>" autofocus>
      <?php
      if ($validation->getError('nova_senha')) {
        echo '<div class="alert alert-danger mt-2">' . $validation->getError('nova_senha') . '</div>';
      }
      ?>
    </div>

    <div class="form-group">
      <label class="sr-only">Confirmar nova Senha</label>
      <input name="cnova_senha" type="text" class="form-control" placeholder="Digite a nova senha novamente" value="<?= set_value('cnova_senha'); ?>">
      <?php
      if ($validation->getError('cnova_senha')) {
        echo '<div class="alert alert-danger mt-2">' . $validation->getError('cnova_senha') . '</div>';
      }
      ?>
    </div>

    
    
    <div class="form-group">
      <button class="btn btn-lg btn-primary btn-block" type="submit">Salvar</button>
    </div>
    <p class="mt-5 mb-3 text-muted">Sistema - SPU/CE</p>
    <input name="token" type="hidden" class="form-control"  value="<?= $token ?>">
  </form>


</body>

</html>
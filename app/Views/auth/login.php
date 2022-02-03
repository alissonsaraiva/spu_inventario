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

  <form action="<?php echo base_url('/auth/check') ?>" method="post" class="form-signin">
    <?php csrf_field(); ?>
    <h1 class="h3 mb-3 font-weight-normal">Login</h1>
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


    if(isset($message)){
      echo '
      <div class="alert alert-success">' . $message . '</div>
      ';
  } 
    ?>
    <div class="form-group">
      <label for="inputEmail" class="sr-only">Email</label>
      <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Digite seu email" value="<?= set_value('email'); ?>" autofocus>
      <?php
      if ($validation->getError('email')) {
        echo '<div class="alert alert-danger mt-2">' . $validation->getError('email') . '</div>';
      }
      ?>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="sr-only">Senha</label>
      <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Digite sua senha" value="<?= set_value('password'); ?>">
      <?php
      if ($validation->getError('password')) {
        echo '<div class="alert alert-danger mt-2">' . $validation->getError('password') . '</div>';
      }
      ?>
    </div>
    <div class="form-group">
      <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
    </div>
    <a class="" href="<?php echo base_url('auth/register') ?>">Cadastre-se</a><br/>
    <a class="" href="<?php echo base_url('auth/esqueceu_senha') ?>">Esqueceu a senha?</a>
    <p class="mt-5 mb-3 text-muted">Sistema - SPU/CE</p>

  </form>


</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
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

  <form action="<?php echo base_url('/auth/save') ?>" method="post" class="form-signin">
    <?php csrf_field(); ?>
    <h1 class="h3 mb-3 font-weight-normal">Registro</h1>
    <hr />
    <?php
    $session = \Config\Services::session();
    if ($session->getFlashdata('success')) {
      echo '
        <div class="alert alert-success">' . $session->getFlashdata("success") . '</div>
        ';
    }
    if ($session->getFlashdata('fail')) {
      echo '
        <div class="alert alert-danger">' . $session->getFlashdata("fail") . '</div>
        ';
    }
    ?>
    <div class="form-group">
      <label for="" class="sr-only">Nome</label>
      <input name="nome" type="text" class="form-control" placeholder="Digite seu nome completo" value="<?= set_value('nome'); ?>" autofocus>
      <?php
      if ($validation->getError('nome')) {
        echo '<div class="alert alert-danger mt-2">' . $validation->getError('nome') . '</div>';
      }
      ?>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="sr-only">Email</label>
      <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Digite seu email" value="<?= set_value('email'); ?>">
      <?php
      if ($validation->getError('email')) {
        echo '<div class="alert alert-danger mt-2">' . $validation->getError('email') . '</div>';
      }
      ?>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="sr-only">Password</label>
      <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Digite sua senha" value="<?= set_value('password'); ?>">
      <?php
      if ($validation->getError('password')) {
        echo '<div class="alert alert-danger mt-2">' . $validation->getError('password') . '</div>';
      }
      ?>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="sr-only">Password</label>
      <input name="cpassword" type="password" id="inputPassword" class="form-control" placeholder="Confirme sua senha" value="<?= set_value('cpassword'); ?>">
      <?php
      if ($validation->getError('cpassword')) {
        echo '<div class="alert alert-danger mt-2">' . $validation->getError('cpassword') . '</div>';
      }
      ?>
    </div>
    <div class="form-group">
      <button class="btn btn-lg btn-primary btn-block" type="submit">Registrar</button>
    </div>
    <a class="mt-5 mb-3" href="<?php echo base_url('auth') ?>">Já tem cadastro? Faça o Login</a>
    <p class="mt-5 mb-3 text-muted">Sistema - SPU/CE</p>
  </form>

</body>

</html>
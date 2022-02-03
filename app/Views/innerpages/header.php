<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
   
    <link href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" id="bootstrap-css">

    <script src="<?php echo base_url('public/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('public/js/jquery-3.6.0.min.js') ?>"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <title><?php echo $title; ?></title>

    <script>

$(document).ready( function(){
  setTimeout(function () {
              $(".alert").fadeOut("fast");
            
       }, 10000);
});
    
    </script>
    

</head>
<body>

<div class="container">

<nav class="navbar navbar-expand-md navbar-light bg-light" style="background-color: rgba(0,0,0,.05)!important;">
<ul class="navbar-nav mr-auto">

    <?php if($usuarioInfo['consultar_servidores'] == 0): ?>
    
    <li class="nav-item active">
    <a class="nav-item nav-link active" href="<?php echo base_url('/crud')?>">Inventário </a>
    </li> 

    <?php endif ?>
    
    <?php if($usuarioInfo['admin'] == 1): ?>

<li class="nav-item active">
<a class="nav-item nav-link active" href="<?php echo base_url('/desaparecidos')?>">Processos Desaparecidos </a>
</li>

<?php endif ?>

<?php if($usuarioInfo['admin'] == 1): ?>

<li class="nav-item active">
<a class="nav-item nav-link active" href="<?php echo base_url('/produtividade')?>">Produtividade</a>
</li>

<?php endif ?>
    
    <?php if($usuarioInfo['admin'] == 1): ?>

        <li class="nav-item active">
        <a class="nav-item nav-link active" href="<?php echo base_url('/usuarios')?>">Gestão de Usuários </a>
        </li>

    <?php endif ?>

    <?php if($usuarioInfo['admin'] == 1 || $usuarioInfo['consultar_servidores'] == 1): ?>

      <li class="nav-item active">
      <a class="nav-item nav-link active" href="<?php echo base_url('/servidores')?>">Gestão de Servidores</a>
      </li>

    <?php endif ?>

  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
    <a class="nav-item nav-link active" href="<?php echo base_url('/auth/logout')?>">Sair</a>
    </li>
  </ul>
</nav>







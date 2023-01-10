<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/fa/css/all.min.css'); ?>">
  


    
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   
    


    <title><?= $title; ?></title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url('dashboard'); ?>">Program</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto">
        <a class="nav-link"><i class="fa fa-user"></i> <?= $admin->nama_admin; ?></a>
        <a class="nav-link" href="<?=  base_url('admin'); ?>"><i class="fa fa-cog"></i> Settings</a>
        <a class="nav-link" href="<?= base_url('welcome/logout'); ?>"><i class="fa fa-sign-out-alt"></i> Logout</a>
      </div>
    </div>
  </div>
</nav>
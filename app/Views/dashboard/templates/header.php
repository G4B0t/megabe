<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Megabe</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

     <!-- Favicons -->
  <link href="<?= base_url()?>/img/favicon.png" rel="icon">
  <link href="<?= base_url()?>/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="<?= base_url()?>/css/googleFont.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url()?>/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url()?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url()?>/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url()?>/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url()?>/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= base_url()?>/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url()?>/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url()?>/css/style.css" rel="stylesheet">

  <link href="<?= base_url()?>/css/imagenes.css" rel="stylesheet">

</head>
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top <?= $tipo ?> ">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="/home">MEGABE</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <?php switch ($rol) {
            case "Normal":
                echo view("dashboard/templates/menus/menu_inicial");
            break;
            case "Cliente":
                echo view("dashboard/templates/menus/menu_cliente");
                break;
            case "Cajero":
                echo view("dashboard/templates/menus/menu_cajero");
                break;
            case "Vendedor":
                echo view("dashboard/templates/menus/menu_vendedor");
                break;
            case "Almacenes":
                echo view("dashboard/templates/menus/menu_almacenes");
                break;
            case "Contador":
                  echo view("dashboard/templates/menus/menu_contabilidad");
                  break;
            case "Administrador":
                  echo view("dashboard/templates/menus/menu_administrador");
                  break;
            case "Vendedor-Cajero":
                  echo view("dashboard/templates/menus/menu_vendedor");
                  echo view("dashboard/templates/menus/menu_cajero");
                  break;
          }?>
        <li><a class="getstarted scrollto" href="/<?= $log?>"><?= $log?></a></li>
        </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header>
  





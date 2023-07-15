<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Agency - Start Bootstrap Theme</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="<?php echo base_url()?>public/assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
       <!-- <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>-->
       <script src="https://kit.fontawesome.com/e56cfcec1d.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />

     <!--     <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css"> -->
        <!-- Core theme CSS (includes Bootstrap)-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">

        <!--JQUERY-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!--ALERTS-->
        <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css
" rel="stylesheet">

        <link href="<?php echo base_url()?>public/css/styles.css" rel="stylesheet" />
        <!--TIRAR ESSE STYLER DPS-->
        <?php
            if(isset($styles)){
                foreach($styles as $style_name){

                    $href = base_url() . "public/css/" . $style_name; ?>
                        <link href="<?= $href ?>" rel="stylesheet"/>
                    <?php 
                    

                }
            } 
        
        ?>
      
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-shrink" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top">LOGO PLATAFORMA</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>#services">Cursos</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>#team">Equipe</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>#contact">Contato</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>#about">Sobre</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>AreaRestrita">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>



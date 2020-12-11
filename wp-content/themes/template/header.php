<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Freelancer - Start Bootstrap Theme</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="<?=  get_template_directory_uri(); ?>/img/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <!-- Google fonts-->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="" rel="stylesheet" />
    <?php
        wp_head();
    ?>
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="<?= get_site_url();?>">Start Bootstrap</a>
            <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <?php
                        wp_nav_menu(array(
                            'theme_location'    => 'primary-menu',
                            'menu_class'        =>  'nav-item mx-0 mx-lg-1'
                        ));
                    ?>
                </ul>
            </div>
        </div>
    </nav>

   
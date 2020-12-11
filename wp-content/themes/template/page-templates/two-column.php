<?php /* Template Name: Two Column */ ?>
<?php
get_header();
?>
<!-- Masthead-->
<header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column">
        <!-- Masthead Avatar Image-->
        <img class="masthead-avatar mb-5" src="<?php echo get_template_directory_uri(); ?>/assets/img/avataaars.svg" alt="" />
        <!-- Masthead Heading-->
        <h1 class="masthead-heading text-uppercase mb-0">
            <?php echo get_the_title(); ?>
        </h1>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Masthead Subheading-->
        <p class="masthead-subheading font-weight-light mb-0">Graphic Artist - Web Designer - Illustrator</p>
    </div>
</header>
<!-- Portfolio Section-->
<section class="page-section portfolio" id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php echo get_the_content(); ?>
            </div>
            <div class="col-md-3">
                Banner1
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>
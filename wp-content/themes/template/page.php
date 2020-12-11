<?php get_header(); ?>


<!-- Portfolio Section-->
<section class="page-section portfolio" id="portfolio">
    <div class="container">
        <!-- Portfolio Section Heading-->
        <h2 class="page-section-heading text-uppercase text-secondary mb-0"><?php echo get_the_title();?></h2>
       
        <div class="row justify-content-center">
           <?php echo get_the_content();?>
        </div>
    </div>
</section>
<!-- About Section-->

<?php get_footer(); ?>
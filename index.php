<?php get_header(); ?>

<div class="main-row mb_85">
    <div class="flex-row">
        <?php while ( have_posts() ) : the_post(); ?>			
            <?php the_content(); ?>			
        <?php endwhile; ?>
        
    </div>
</div>

<?php get_footer(); ?>
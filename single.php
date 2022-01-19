<?php get_header();

    echo the_content();
    $getPost = get_the_content();
    $postwithbreaks = wpautop( $getPost, true );//true/false
    echo apply_filters( 'the_content', $postwithbreaks );
    
?>


<?php get_footer(); ?>
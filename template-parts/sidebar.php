<?php 

$user_id = get_current_user_id();
$user_terms = wp_get_object_terms( $user_id, 'profession');

$user_slugs = [];
foreach($user_terms as $user_term)
    $user_slugs[] = $user_term->slug;

$question_categories = get_terms(
    array( 
        'taxonomy'      => 'question_category', 
    ),
    array(
        'hide_empty'     => false,
    ),
);

foreach ($question_categories as $question_category) {
    // $slugs = array();
    // array_push($slugs, $question_category->slug, 'multiple_chapters');

    $questions = get_posts(array(
        'post_type' => 'question',
        'posts_per_page' => -1,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'question_category',
                'field'     => 'slug',
                'terms' => $question_category->slug,
            ),
            array(
                'taxonomy' => 'vcategory',
                'field'     => 'slug',
                'terms' => $user_slugs,
            )
        )   
    ));
    $counts[$question_category->slug] = count($questions);
}

$icon_backcolors = array('#e56969', '#1d9bd1', '#515151', '#613ec2', '#67a3e0', '#e0991f', '#1FE099', '#766d97');
$i = 0;
?>
<div>
    <a href="<?php echo BASE_URL; ?>/questions/ask"><div class="sidebar-query">質問はこちら</div></a>
    
    <div class="sidebar-title">カテゴリー</div>
    <?php
    $categories_html = '<ul class="ap-cat-wid clearfix" id ="ap-categories-widget">';
    foreach ($question_categories as $question_category) {
        $categories_html .= '<li class="clearfix">';

        if (ap_category_have_image($question_category->term_id)) {
            $option = get_term_meta( $question_category->term_id, 'ap_category', true );
            $color  = ! empty( $option['color'] ) ? ' background:' . $option['color'] . ';' : 'background:#333;';
            $style = 'style="' . $color . 'height: 32px;"';
        
            $categories_img = wp_get_attachment_image_src( $option['image']['id'], 'full', false )[0];
            $categories_html .= '<img class="ap-category-img" src="' . $categories_img . '"></img>';
        }
        else {
            // $categories_html .= '<span class="ap-category-icon" style="background-color: ' . $icon_backcolors[$i++] . ';">' . mb_substr($question_category->slug, 0, 1) . '</span>';
        }
        
        $categories_html .= '<a class="ap-cat-title" href="' . get_category_link( $question_category ). '">'. $question_category->name .'</a>';
        $categories_html .= '<div class="ap-cat-count"> <span>' . $counts[$question_category->slug] . ' 件質問</span></div>';
        $categories_html .= '</li>';

        $i = $i % sizeof($icon_backcolors);
    }
    $categories_html .= '</ul>';
    echo $categories_html;
    ?>

    <div class="sidebar-title second">タグ</div>
    <?php

    $tags_html = '<div class "ap-tag-wid clearfix">';
    $tags = get_tags(array(
        'hide_empty'    => false,
        'taxonomy'      => 'question_tag'
    ));

    foreach ($tags as $tag) {
        $tag_link = get_tag_link($tag->term_id);
        $tags_html .= '<a href="' . $tag_link . '" title="' . $tag->name . '" class="ap-tag-item">' . $tag->name . '</a>';
    }
    $tags_html .= '</div>';

    echo $tags_html;
        
    remove_filter( 'the_title', 'japanworm_shorten_title' );
    ?>
</div>
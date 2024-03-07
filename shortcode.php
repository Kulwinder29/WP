<?php

function bracelets_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'orderby' => 'date',
        'limit' => '-1',
    ), $atts);

    $user_id = get_current_user_id();

    $post__not_in = swaped_bracelts();

    $args = array(
        'post_type' => 'bracelet',
        'posts_per_page' => $atts['limit'],
        // 'posts_per_page' => 4,
        'orderby' => $atts['orderby'],
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
        'author__not_in' => is_user_logged_in() ? array($user_id) : array(),
        'post__not_in' => $post__not_in,
    );

    $output = '';

    $custom_query = new WP_Query($args);

    ob_start();

    if ($custom_query->have_posts()) {
        echo '<div class="row">';
        while ($custom_query->have_posts()) {
            $custom_query->the_post();
            $thumbnail_id = get_post_thumbnail_id();
            $thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'bracelet_thumbnail_size');
?>
            <div class="col-lg-4 col-md-6">
                <div class="product-block">
                    <img src="<?php echo $thumbnail_src[0]; ?>" height="261px" width="261px" style="height:261px">
                    <?php
                    $favorite = get_post_meta(get_the_ID(), 'favorite', true);
                    ?>
                    <button class="like-button <?php echo ($favorite[$user_id]) ? "is_favorite" : "" ?>" data-post-id="<?php the_ID(); ?>"><img src="https://suggyswapdev.wpenginepowered.com/wp-content/uploads/2024/02/mdi_heart-outline.svg"></button>
                    <a href="<?php the_permalink(); ?>" class="product-title"><?php the_title(); ?></a>
                    <div class="upload-date"><span>Uploaded on: </span><?php echo get_the_date('j M, Y') ?> </div>
                    <div class="user-profile">
                        <span><?php echo strtoupper(substr(get_the_author(), 0, 1)) ?></span>
                        <?php echo get_the_author() ?>
                    </div>
                </div>
            </div>
<?php
        }
        echo '</div>';
    } else {
        echo 'No bracelets found.';
    }
    $output = ob_get_clean();
    wp_reset_postdata();

    return $output;
}
add_shortcode('bracelets', 'bracelets_shortcode');


// Shortcode  new
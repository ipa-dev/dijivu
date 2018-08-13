<div class="acc_nav">
    <h2><a href="<?php bloginfo('url'); ?>/my-account/">My Account<span>+</span></a></h2>
    <?php wp_nav_menu(array('theme_location' => 'my-account-menu1')); ?>
    <hr />
    <h2><a href="<?php bloginfo('url'); ?>/book-cases/">MY BOOKCASES<span>+</span></a></h2>
    <?php
        $args = array(
            'post_type' => 'bookcase',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'author' => $user_ID
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) :
    ?>
    <ul>
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <li><a href="<?php the_permalink(); ?>"><i class="fa fa-book"></i><?php the_title(); ?></a></li>
        <?php endwhile; ?>
    </ul>
    <?php
        endif;
        wp_reset_postdata();
    ?>
    <hr />
    <?php wp_nav_menu(array('theme_location' => 'my-account-menu2')); ?>
</div>
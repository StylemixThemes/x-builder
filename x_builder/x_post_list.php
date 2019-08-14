<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $title
 * @var $carousel
 * @var $categories
 * @var $total
 * @var $words
 * @var $custom_css
 */

$params = stm_x_builder_get_params( $module, $params );
extract( $params );
$module_id = stm_x_builder_module_id( $module, $params );
$classes[] = $module_id;
$inline_styles = ( empty( $custom_css ) ) ? '' : $custom_css;
$cats = array();
if( !empty( $categories ) ) {
    foreach( $categories as $category_key => $category ) {
        /*Category Icon*/
        $cats[] = $category[ 'term_id' ];
    }
}
wp_enqueue_style( 'owl-carousel' );
stm_x_builder_register_style( $module, array(), $inline_styles );
stm_x_builder_register_script( $module, array( 'imagesloaded', 'owl-carousel' ), '', $module_id, array(
    'carousel' => $carousel
) );
$total = !empty( $total ) ? $total : 3;

$args = array(
    'post_type' => 'post',
    'posts_per_page' => $total,
);

if( !empty( $cats ) ) {
    $args[ 'tax_query' ] = array(
        array(
            'field' => 'term_id',
            'taxonomy' => 'category',
            'terms' => $cats
        )
    );
}

$q = new WP_Query( $args );
?>

<div class="x_post_list_wrapper <?php if( $simple ) echo 'simple'; ?> <?php echo esc_attr($module_id); ?>" data-module="<?php echo esc_attr( $module_id ); ?>">
    <?php if( !empty( $title ) ): ?>
        <div class="x_post_list_wrapper__title">
            <h3 class="title">
                <?php echo wp_kses_post( $title ); ?>
            </h3>
            <?php if( $carousel ): ?>
                <div class="x_owl_nav">
                    <span class="prev"></span>
                    <span class="next"></span>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if( $simple ): ?>
        <div class="x_post_list">
            <?php
            if( $q->have_posts() ):
                while ( $q->have_posts() ):
                    $q->the_post();
                    $id = get_the_ID();
                    ?>
                    <div class="x_post_item">
                        <div class="x_post_item__date">
                            <span class="day"><?php echo get_the_date('d'); ?></span>
                            <span class="month"><?php echo get_the_date('M'); ?></span>
                        </div>
                        <div class="x_post_item__title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </div>
                    </div>
                <?php
                endwhile;

                wp_reset_postdata();
            endif;
            ?>
        </div>
    <?php else: ?>
        <div class="x_post_list <?php echo esc_attr( $carousel ) ? 'owl-carousel' : ''; ?>">
            <?php
            if( $q->have_posts() ):
                while ( $q->have_posts() ):
                    $q->the_post();
                    $id = get_the_ID();
                    ?>
                    <div class="x_post_list__item">
                        <div class="x_post_list__item_image">
                            <div class="post-date heading_font">
                                <div class="day">
                                    <?php echo get_the_date( 'd' ); ?>
                                </div>
                                <div class="month">
                                    <?php echo get_the_date( 'M' ); ?>
                                </div>
                            </div>
                            <div class="image">
                                <?php if( has_post_thumbnail() ): ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url( stm_x_builder_get_cropped_image_url( get_post_thumbnail_id(), 150, 150 ) ); ?>"
                                             alt="<?php the_title_attribute(); ?>"/>
                                    </a>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="x_post_list__item_content">
                            <h4>
                                <a href="<?php the_permalink(); ?>" class="stc_hv">
                                    <?php the_title(); ?>
                                </a>
                            </h4>
                            <div class="excerpt heading_font">
                                <?php echo esc_attr( empty( $words ) ) ? get_the_excerpt() : wp_trim_words( get_the_excerpt(), 15 ); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="stc_hv">
                                <?php esc_html_e( 'Read more', 'x-builder' ); ?>
                            </a>
                        </div>
                    </div>
                <?php
                endwhile;
            endif; ?>
        </div>
    <?php endif; ?>
</div>
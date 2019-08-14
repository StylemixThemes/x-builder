<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $title
 * @var $categories
 * @var $posts_per_page
 * @var $custom_css
 */
$params = stm_x_builder_get_params( $module, $params );
extract( $params );
$classes = array();
$module_id = stm_x_builder_module_id( $module, $params );
$classes[] = $module_id;
$inline_styles = ( empty( $custom_css ) ) ? '' : $custom_css;

stm_x_builder_register_style( $module, array(), $inline_styles );
stm_x_builder_register_script( $module, array( 'jquery', 'owl-carousel' ), array() );

if( empty( $posts_per_page ) ) {
    $posts_per_page = '10';
}
$terms = array();
if( !empty( $categories ) ) {
    foreach( $categories as $category ) {
        $terms[] = $category[ 'term_id' ];
    }
}
$args = array(
    'post_type' => 'product',
    'posts_per_page' => $posts_per_page,
);

if( !empty( $terms ) ) {
    $args[ 'tax_query' ] = array(
        array(
            'field' => 'term_id',
            'taxonomy' => 'product_cat',
            'terms' => $terms
        )
    );
}
$q = new WP_Query( $args );
?>
<div class="x_products_carousel <?php echo implode( ' ', $classes ); ?>">
    <?php if( !empty( $title ) ): ?>
        <h2 class="title">
            <?php echo esc_html( $title ); ?>
        </h2>
    <?php endif; ?>
    <?php if( $q->have_posts() ): ?>
        <div class="x_owl_nav_wrap">
            <div class="x_owl_nav"><span class="prev"></span> <span class="next"></span></div>
        </div>
    <?php endif; ?>
    <div class="x_products_carousel_inner owl-carousel" data-module="<?php echo esc_attr( $module_id ); ?>">
        <?php
        if( $q->have_posts() ):
            $i = 0;
            while ( $q->have_posts() ):
                $q->the_post();
                $id = get_the_ID();
                $_product = wc_get_product( $id );
                $product_cats = get_the_terms( $id, 'product_cat' );
                $price = $_product->get_price();
                $regular_price = $_product->get_regular_price();
                $sale_price = $_product->get_sale_price();
                ?>
                <div class="x_carousel-item-wrap">
                    <div class="x_carousel-item">
                        <?php if( !empty( $product_cats ) ): ?>
                            <div class="x_carousel-item__title">
                                <a href="<?php echo get_term_link( $product_cats[ 0 ]->term_id, 'product_cat' ); ?>"
                                   class="category_title"><?php echo esc_html( $product_cats[ 0 ]->name ); ?></a>
                                <a href="<?php echo get_term_link( $product_cats[ 0 ]->term_id, 'product_cat' ); ?>"
                                   class="category_label">
                                    <?php esc_html_e( 'View all Deals', 'x-builder' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if( has_post_thumbnail() ): ?>
                            <div class="x_carousel-item__img">
                                <img src="<?php echo esc_url( stm_x_builder_get_cropped_image_url( get_post_thumbnail_id(), 300, 360 ) ); ?>"
                                     alt="<?php the_title(); ?>"/>
                            </div>
                        <?php endif; ?>
                        <div class="x_carousel-item__product-info">
                            <div class="title">
                                <a href="<?php the_permalink(); ?>" class="heading_font">
                                    <?php the_title(); ?>
                                </a>
                            </div>
                            <div class="price">
                                <?php
                                $_product = wc_get_product( get_the_ID() );
                                $regular_price = $_product->get_regular_price();
                                $sale_price = $_product->get_sale_price();
                                $symbol = get_woocommerce_currency_symbol();
                                $price_class = 'regular_price';
                                if( empty( $sale_price ) ) {
                                    $price_class = 'sale_price';
                                }
                                if( !empty( $sale_price ) ) {
                                    $sale_price = floatval( $sale_price );
                                    echo '<span class="sale_price"><span>' . esc_html( $symbol ) . '</span>' .esc_html( number_format( $sale_price, 2, '.', ' ' ) ) . '</span>';
                                }
                                if( !empty( $regular_price ) ) {
                                    $regular_price = floatval( $regular_price );
                                    echo '<span class="'.esc_attr( $price_class ).'"><span>'.esc_html( $symbol ).'</span>'.esc_html( number_format( $regular_price, 2, '.', ' ' ) ).'</span>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            endwhile;

            wp_reset_postdata();
        endif; ?>
    </div>
</div>


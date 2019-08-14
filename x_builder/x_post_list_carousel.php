<?php
/**
 *
 * @var $params
 * @var $name
 * @var $module
 * @var $carousel
 * @var $categories
 * @var $total
 * @var $custom_css
 */

$params = stm_x_builder_get_params( $module, $params );
extract( $params );
$module_id = stm_x_builder_module_id( $module, $params );
$classes[] = $module_id;
$inline_styles = ( empty( $custom_css ) ) ? '' : $custom_css;

$cats = array();
if ( !empty( $categories ) ) {
	foreach ( $categories as $category_key => $category ) {
		/*Category Icon*/
		$cats[] = $category[ 'term_id' ];
	}
}
$deps = array();
$style_deps = array();
if ( $carousel ) {
	$deps[] = 'imagesloaded';
	$deps[] = 'owl-carousel';
	$style_deps[] = 'owl-carousel';
}
stm_x_builder_register_script( $module, $deps, '' );
stm_x_builder_register_style( $module, $style_deps, $inline_styles );
$total = !empty( $total ) ? $total : 3;

$args = array(
	'post_type' => 'post',
	'posts_per_page' => $total,
);

if ( !empty( $cats ) ) {
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

<div class="x_post_list_carousel <?php if($carousel) echo esc_attr('owl-carousel'); ?>">
	<?php
	if ( $q->have_posts() ):
		while ( $q->have_posts() ):
			$q->the_post();
			$id = get_the_ID();
			?>
			<div class="x_post_list_carousel__item <?php echo has_post_thumbnail() ? 'with_image' : ''; ?>">
				<div class="x_post_list_carousel__item_image">
					<div class="post-date heading_font">
						<div class="day">
							<?php echo get_the_date( 'd' ); ?>
						</div>
						<div class="month">
							<?php echo get_the_date( 'M' ); ?>
						</div>
					</div>
					<div class="image">
						<?php if ( has_post_thumbnail() ): ?>
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo esc_url( stm_x_builder_get_cropped_image_url( get_post_thumbnail_id(), 345, 345 ) ); ?>"
								     alt="<?php the_title_attribute(); ?>"/>
							</a>
						<?php endif; ?>
					</div>
				</div>
				<div class="x_post_list_carousel__item_content">
					<h4>
						<a href="<?php the_permalink(); ?>" class="stc_hv">
							<?php the_title(); ?>
						</a>
					</h4>
					<div class="excerpt heading_font">
						<?php echo get_the_excerpt(); ?>
					</div>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="stc_hv">
						<?php esc_html_e( 'Read more', 'x-builder' ); ?>
					</a>
				</div>
			</div>
		<?php
		endwhile;

        wp_reset_postdata();
	endif; ?>
</div>
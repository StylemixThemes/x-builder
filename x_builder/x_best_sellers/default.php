<div class="x_best_sellers__module" data-v-on_mouseover="hover=true">

    <div class="x_best_sellers__head">

        <h3 class="title"><?php echo sanitize_text_field($title); ?></h3>

        <div class="x_best_sellers__categories" data-v-if="categories.length > 1">
            <div class="x_best_sellers__category"
                 data-v-for="(category, index) in categories"
                 data-v-on_click.prevent="getProducts(category)"
                 data-v-bind_data-title="unescape(category.name)"
                 data-v-bind_class="{'active' : category.term_id == (active_category)}">

                <i data-v-bind_class="category.icon" data-v-if="category.icon"></i>
            </div>
        </div>

    </div>

    <div class="x_best_sellers__products_rows"
         data-v-if="typeof products[active_category] !== 'undefined'">

        <h4 data-v-if="!products[active_category].length && !loading"><?php esc_html_e('No Best Sellers products now', 'x-builder'); ?></h4>


        <div data-v-if="!loading"
             data-v-bind_class="rowClasses(row_num)"
             data-v-for="(row, row_num) in rows">

            <div class="x_best_sellers__products"
                 data-v-bind_key="row_num" data-v-bind_class="'x_best_sellers__' + active_category"
                 data-v-bind_data-cat="active_category">

                <a data-v-bind_href="products[active_category][product_index].permalink"
                   class="x_best_sellers__product x_product_buttons_wrapper x_woo_image_wrapper"
                   data-v-bind_class="'x_best_sellers__product_' + product_index"
                   data-v-for="product_index in row"
                   data-v-bind_key="product_index + row_num"
                   data-v-if="products[active_category][product_index]">

                    <div class="x_product_buttons" data-v-html="products[active_category][product_index].buttons"></div>

                    <div class="x_best_sellers__product__sale x_best_sellers__product__label heading_font"
                         data-v-if="products[active_category][product_index].discount"
                         data-v-html="'-' + products[active_category][product_index].discount + '%'">
                    </div>

                    <div class="x_best_sellers__product__stock x_best_sellers__product__label heading_font"
                         data-v-if="products[active_category][product_index].quantity === 0">
                        <?php esc_html_e('Out of stock', 'x-builder') ?>
                    </div>

                    <div class="x_best_sellers__product__image">

                        <div class="x_woo_image_hover" data-v-if="products[active_category][product_index].gallery">

                            <img src="#"
                                 alt="<?php esc_attr_e('Product image', 'STM_X_Builder_Front'); ?>"
                                 data-v-bind_src="products[active_category][product_index].image"
                                 data-v-bind_alt="products[active_category][product_index].title"/>

                            <img src="#"
                                 data-v-if="hover"
                                 alt="<?php esc_attr_e('Product image', 'STM_X_Builder_Front'); ?>"
                                 data-v-bind_src="products[active_category][product_index].gallery"
                                 data-v-bind_alt="products[active_category][product_index].title"/>

                        </div>

                        <img src="#"
                             alt="<?php esc_attr_e('Product image', 'STM_X_Builder_Front'); ?>"
                             data-v-bind_src="products[active_category][product_index].image"
                             data-v-else
                             data-v-bind_alt="products[active_category][product_index].title"/>


                    </div>

                    <div class="x_best_sellers__product__content">

                        <h6 class="x_best_sellers__product__title"
                            data-v-html="products[active_category][product_index].title"></h6>

                        <div class="x_best_sellers__product__single_timer heading_font">
                            <div data-vue-role="Timer" data-v-bind_starttime="products[active_category][product_index].sale_to"
                                 data-v-bind_endtime="products[active_category][product_index].sale_to"
                                 data-v-if="products[active_category][product_index].sale_to"
                                 data-vue-trans='{"day":"<?php esc_attr_e('Day', 'x-bulder'); ?>","hours":"<?php esc_attr_e('Hours', 'x-bulder'); ?>","minutes":"<?php esc_attr_e('Minutes', 'x-bulder'); ?>","seconds":"<?php esc_attr_e('Seconds', 'x-bulder'); ?>"}'>
                            </div>
                        </div>

                        <div class="x_best_sellers__product__price">
                                <span class="regular_price"
                                      data-v-html="products[active_category][product_index].regular_price"
                                      data-v-if="products[active_category][product_index].sale_price">
                                </span>
                            <span class="price" data-v-html="products[active_category][product_index].price"></span>
                        </div>

                    </div>

                </a>
            </div>


        </div>


        <div class="x_loader_wrapper" data-v-if="loading">
            <div class="x_loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

    </div>
</div>
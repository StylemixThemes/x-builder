<div class="x_best_sellers__module" @mouseover="hover=true">

    <div class="x_best_sellers__head">

        <h3 class="title"><?php echo sanitize_text_field($title); ?></h3>


        <div class="x_best_sellers__categories" v-if="categories.length > 1">
            <div class="x_best_sellers__category"
                 v-for="(category, index) in categories"
                 @click.prevent="getProducts(category)"
                 v-bind:data-title="category.name"
                 v-bind:class="{'active' : category.term_id == (active_category)}">

                <i v-bind:class="category.icon" v-if="category.icon"></i>
            </div>
        </div>

    </div>

    <div class="x_best_sellers__products_rows"
         v-if="typeof products[active_category] !== 'undefined'">

        <h4 v-if="!products[active_category].length && !loading"><?php esc_html_e('No Best Sellers products now', 'x-builder'); ?></h4>


        <div v-if="!loading"
             v-bind:class="rowClasses(row_num)"
             v-for="(row, row_num) in rows">

            <div class="x_best_sellers__products"
                 :key="row_num" v-bind:class="'x_best_sellers__' + active_category" v-bind:data-cat="active_category">

                <a v-bind:href="products[active_category][product_index].permalink"
                   class="x_best_sellers__product x_product_buttons_wrapper x_woo_image_wrapper"
                   v-bind:class="'x_best_sellers__product_' + product_index"
                   v-for="product_index in row"
                   :key="product_index + row_num"
                   v-if="products[active_category][product_index]">

                    <div class="x_product_buttons" v-html="products[active_category][product_index].buttons"></div>

                    <div class="x_best_sellers__product__sale x_best_sellers__product__label heading_font"
                         v-if="products[active_category][product_index].discount"
                         v-html="'-' + products[active_category][product_index].discount + '%'">
                    </div>

                    <div class="x_best_sellers__product__stock x_best_sellers__product__label heading_font"
                         v-if="products[active_category][product_index].quantity === 0">
                        <?php esc_html_e('Out of stock', 'x-builder') ?>
                    </div>

                    <div class="x_best_sellers__product__image">

                        <div class="x_woo_image_hover" v-if="products[active_category][product_index].gallery">

                            <img src="#"
                                 alt="<?php esc_attr_e('Product image', 'STM_X_Builder_Front'); ?>"
                                 v-bind:src="products[active_category][product_index].image"
                                 v-bind:alt="products[active_category][product_index].title"/>

                            <img src="#"
                                 v-if="hover"
                                 alt="<?php esc_attr_e('Product image', 'STM_X_Builder_Front'); ?>"
                                 v-bind:src="products[active_category][product_index].gallery"
                                 v-bind:alt="products[active_category][product_index].title"/>

                        </div>

                        <img src="#"
                             alt="<?php esc_attr_e('Product image', 'STM_X_Builder_Front'); ?>"
                             v-bind:src="products[active_category][product_index].image"
                             v-else
                             v-bind:alt="products[active_category][product_index].title"/>


                    </div>

                    <div class="x_best_sellers__product__content">

                        <div class="x_best_sellers__product__price">
                                <span class="regular_price"
                                      v-html="products[active_category][product_index].regular_price"
                                      v-if="products[active_category][product_index].sale_price">
                                </span>
                            <span class="price" v-html="products[active_category][product_index].price"></span>
                        </div>

                        <h6 class="x_best_sellers__product__title"
                            v-html="products[active_category][product_index].title"></h6>

                        <div class="x_best_sellers__product__single_timer heading_font">
                            <Timer :starttime="products[active_category][product_index].sale_to"
                                   :endtime="products[active_category][product_index].sale_to"
                                   v-if="products[active_category][product_index].sale_to"
                                   trans='{"day":"<?php esc_attr_e('Day', 'x-bulder'); ?>","hours":"<?php esc_attr_e('Hours', 'x-bulder'); ?>","minutes":"<?php esc_attr_e('Minutes', 'x-bulder'); ?>","seconds":"<?php esc_attr_e('Seconds', 'x-bulder'); ?>"}'>
                            </Timer>
                        </div>

                    </div>

                </a>
            </div>


        </div>


        <div class="x_loader_wrapper" v-if="loading">
            <div class="x_loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

    </div>
</div>
<div>
    <div class="stmt-to-typography">

        <div class="row">
            <div class="column column-50">
				<?php esc_html_e('Font Family', 'stm-configurations'); ?>
                <select v-model="typography['font-family']" placeholder="adas">
					<?php foreach (stmt_get_google_fonts() as $k => $val) : ?>
                        <option value="<?php echo stm_x_filtered_output($k); ?>"><?php echo stm_x_filtered_output($val); ?></option>
					<?php endforeach; ?>
                </select>
            </div>

            <div class="column column-50">

				<?php esc_html_e('Color', 'stm-configurations'); ?>
                <div class="stmt_colorpicker_wrapper" style="width: 100%">
                    <span v-bind:style="{'background-color': color}"></span>
                    <input type="text" v-model="color"/>
                    <stmt-color v-on:get-color="color = $event"></stmt-color>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="column column-50">
				<?php esc_html_e('Font Size', 'stm-configurations'); ?>
                <input type="text" v-model="typography['font-size']"/>
            </div>

            <div class="column column-50">

				<?php esc_html_e('Line Height', 'stm-configurations'); ?>
                <input type="text" v-model="typography['line-height']"/>
            </div>

        </div>


        <div class="row">
            <div class="column column-50">
				<?php esc_html_e('Font Weight', 'stm-configurations'); ?>
                <select v-model="typography['font-weight']">
                    <option value=""><?php esc_html_e('Default', 'stm-configurations'); ?></option>
                    <option value="200"><?php esc_html_e('Thin', 'stm-configurations'); ?></option>
                    <option value="300"><?php esc_html_e('Light', 'stm-configurations'); ?></option>
                    <option value="400"><?php esc_html_e('Regular', 'stm-configurations'); ?></option>
                    <option value="500"><?php esc_html_e('Medium', 'stm-configurations'); ?></option>
                    <option value="600"><?php esc_html_e('Semi-bold', 'stm-configurations'); ?></option>
                    <option value="700"><?php esc_html_e('Bold', 'stm-configurations'); ?></option>
                    <option value="900"><?php esc_html_e('Ultra Bold', 'stm-configurations'); ?></option>
                </select>
            </div>

            <div class="column column-50">

				<?php esc_html_e('Letter Spacing', 'stm-configurations'); ?>
                <input type="text" v-model="typography['letter-spacing']"/>
            </div>

        </div>

<!--		--><?php //esc_html_e('Add classes and tags separating with comma (ex: .class, h1, h2 …)', 'stm-configurations'); ?>
<!--        <input type="text" v-model="selectors"/>-->
    </div>
</div>
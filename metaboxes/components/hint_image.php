<div>

    <div class="stmt-to-image_hint">

        <stm-image v-bind:stored_image="image_id"
                   v-on:get-image="image_id = $event"
                   v-on:get-image-url="image_url = $event"></stm-image>

        <div class="hint-holder-image"
             v-if="image_url"
             @click="startAddingHint(event)">
            <img v-bind:src="image_url"/>

            <div class="hint-current-adding"
                 v-bind:style="{top: currentY, left: currentX}"
                 v-if="currentX !== '' && currentY !== ''">
                <div class="hint-current-adding__plus">+</div>
                <div class="hint-current-adding__form">
                    <input type="text"
                           v-model="currentHint"
                           placeholder="<?php esc_html_e('Hint text', 'stm-configurations'); ?>"/>
                    <span @click.enter="addHint()"><?php esc_html_e('Add', 'stm-configurations'); ?></span>
                </div>
            </div>

            <div class="hint-on-image" v-for="(hint, hint_index) in hints" v-bind:style="{top: hint.y, left: hint.x}">
                <div class="hint-on-image__plus">+</div>
                <div class="hint-on-image__form">
                    <input type="text"
                           v-model="hint['hint']"
                           placeholder="<?php esc_html_e('Edit hint text', 'stm-configurations'); ?>"/>
                    <span @click.enter="deleteHint(hint_index)"><?php esc_html_e('Delete', 'stm-configurations'); ?></span>
                </div>
            </div>

        </div>

    </div>
</div>
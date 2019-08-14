<div>
    <div class="stm-lms-image">
        <div class="image-field" v-if="image_url"><img v-bind:src="image_url"/></div>
        <div class="actions">
            <div class="button" v-if="!image_url"
                 @click="addImage()"><?php esc_html_e('Add Image', 'masterstudy-lms-learning-management-system'); ?></div>
            <div class="button" v-if="image_url"
                 @click="removeImage()"><?php esc_html_e('Remove Image', 'masterstudy-lms-learning-management-system'); ?></div>
            <div class="button" v-if="image_url"
                 @click="addImage()"><?php esc_html_e('Replace Image', 'masterstudy-lms-learning-management-system'); ?></div>
        </div>
    </div>
</div>
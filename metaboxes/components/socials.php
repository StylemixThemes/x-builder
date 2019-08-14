<?php
$socials = array(
    'facebook' => esc_html__('Facebook', 'motors'),
    'facebook-f' => esc_html__('Facebook F', 'motors'),
    'twitter' => esc_html__('Twitter', 'motors'),
    'vk' => esc_html__('VK', 'motors'),
    'instagram' => esc_html__('Instagram', 'motors'),
    'behance' => esc_html__('Behance', 'motors'),
    'dribbble' => esc_html__('Dribbble', 'motors'),
    'flickr' => esc_html__('Flickr', 'motors'),
    'git' => esc_html__('Git', 'motors'),
    'linkedin' => esc_html__('Linkedin', 'motors'),
    'pinterest' => esc_html__('Pinterest', 'motors'),
    'yahoo' => esc_html__('Yahoo', 'motors'),
    'delicious' => esc_html__('Delicious', 'motors'),
    'dropbox' => esc_html__('Dropbox', 'motors'),
    'reddit' => esc_html__('Reddit', 'motors'),
    'soundcloud' => esc_html__('Soundcloud', 'motors'),
    'google' => esc_html__('Google', 'motors'),
    'google-plus' => esc_html__('Google +', 'motors'),
    'skype' => esc_html__('Skype', 'motors'),
    'youtube' => esc_html__('Youtube', 'motors'),
    'youtube-play' => esc_html__('Youtube Play', 'motors'),
    'tumblr' => esc_html__('Tumblr', 'motors'),
    'whatsapp' => esc_html__('Whatsapp', 'motors'),
);
?>

<div>

    <div class="row">
        <div class="column">
            <?php foreach ($socials as $k => $social) : ?>
                <div class="column-50">
                    <label><?php echo stm_x_filtered_output($social); ?></label>
                    <input type="text" @keyup="changed('<?php echo esc_attr($k) ?>')"
                           v-model="faq['<?php echo esc_attr($k); ?>']"/>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php

/**
 * @var $subtitle
 */

?>

<?php if (!empty($subtitle)): ?>
    <h2 class="subtitle"><?php echo sanitize_text_field($subtitle); ?></h2>
<?php endif; ?>
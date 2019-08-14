<?php

/**
 * @var $content
 */

?>

<?php if (!empty($content)): ?>
    <div class="content"><?php echo html_entity_decode($content); ?></div>
<?php endif;
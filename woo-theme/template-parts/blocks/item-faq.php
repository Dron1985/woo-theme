<?php
$post_id = (isset($args['post_id']) && !empty($args['post_id'])) ? $args['post_id'] : '';
$class = (isset($args['active']) && !empty($args['active'])) ? 'class="'.$args['active'].'"' : '';
$style = (isset($args['active']) && !empty($args['active'])) ? 'style="display: block;"' : ''; ?>
<li <?php echo $class; ?>>
    <h5><?php echo get_the_title($post_id); ?>
        <button type="button" class="item-opener">
            <svg width="18" height="11" viewBox="0 0 18 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 9L9 2L2 9" stroke="#151B20" stroke-width="1.5" stroke-linecap="square"/>
            </svg>
        </button>
    </h5>
    <div class="hidden" <?php echo $style; ?>>
        <?php echo get_the_content(); ?>
    </div>
</li>
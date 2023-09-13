<?php $class = (isset($args['class']) && !empty($args['class'])) ? 'social-networks '.$args['class'] : 'social-networks'; ?>
<div class="<?php echo $class; ?>">
    <ul class="socials-list">
        <li>
            <a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://twitter.com/share?text=<?php echo get_the_title(); ?>&url=<?php echo get_the_permalink(); ?>')" target="_blank" rel="nofollow">
                <?php get_template_part('template-parts/svg/icon-twitter'); ?>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.facebook.com/sharer.php?u=<?php echo get_the_permalink(); ?>')" target="_blank" rel="nofollow">
                <?php get_template_part('template-parts/svg/icon-facebook'); ?>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_the_permalink(); ?>')" target="_blank" rel="nofollow">
                <?php get_template_part('template-parts/svg/icon-linkedin', '', array('type' => 'share')); ?>
            </a>
        </li>
        <li>
            <?php
            $title = rawurlencode(get_the_title());;
            $title = str_replace(array('%26%238211%3B', '%26amp%3B'), array('-', '%26'), $title); ?>
            <a href="mailto:?subject=<?php echo $title; ?>&body=<?php echo get_the_permalink(); ?>">
                <?php get_template_part('template-parts/svg/icon-mail', '', array('type' => 'share')); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo get_the_permalink(); ?>" class="copy-link">
                <?php get_template_part('template-parts/svg/icon-copy-link'); ?>
            </a>
        </li>
    </ul>
</div>
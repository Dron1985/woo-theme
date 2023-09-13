<?php
$data = get_field('more_items_fields');
if ( !$data ) {
	return;
};

if (isset($data['global_block']) && $data['global_block'] == true) {
    if (isset($data['type_section'])) :
        switch ($data['type_section']) :
            case 'articles':
                $field = get_field('fields_more_items', 'option');
                $data['type'] = (isset($field['type']) && !empty($field['type'])) ? $field['type'] : '';
                $data['manual_editing'] = (isset($field['manual_editing']) && !empty($field['manual_editing'])) ? $field['manual_editing'] : '';
                break;
            case 'products':
                $field = get_field('fields_more_products', 'option');
                $data['type'] = 'products';
                $data['manual_editing'] = true;
                break;
            case 'wholesales':
                $field = get_field('fields_more_wholesales', 'option');
                $data['type'] = 'products';
                $data['manual_editing'] = true;
                break;
        endswitch;
    endif;

    $data['background'] = (isset($field['background']['url'])) ? $field['background'] : '';
    $data['title'] = (isset($field['title']) && !empty($field['title'])) ? $field['title'] : '';
    $data['use_retail'] = (isset($field['use_retail']) && !empty($field['use_retail'])) ? $field['use_retail'] : '';
    $data['button'] = (isset($field['button']) && !empty($field['button'])) ? $field['button'] : '';
    $data['related_posts'] = (isset($field['related_posts']) && !empty($field['related_posts'])) ? $field['related_posts'] : '';
    $data['related_products'] = (isset($field['related_products']) && !empty($field['related_products'])) ? $field['related_products'] : '';
}

$classes = (isset($data['type']) && $data['type'] == 'products' && isset($data['use_retail']) && $data['use_retail'] == true) ? [ 'more-items-section retail animation' ] : [ 'more-items-section animation' ]; ?>
<?php if (is_empty($data, ['title', 'button', 'background', 'related_posts', 'related_projects'])): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="more-items-heading">
				<?php render( '<h2>', $data, 'title', '</h2>' );
				render( '<div class="buttons"><div class="buttons-holder">', $data, 'button', '</div></div>', 'link', 'btn has-border small', '<span>', '</span>' ); ?>
			</div>
			<div class="more-items-content">
				<?php if ( $data['background']['type'] == 'image' ) :
					render_image( '<div class="more-items-bg">', $data, 'background', '<span class="mask">&nbsp;</span></div>', 'full_hd' );
				elseif ( $data['background']['type'] == 'video' ) : ?>
					<div class="more-items-bg">
						<video class="video-bg" muted autoplay loop>
							<source src="<?php echo $data['background']['url']; ?>" type="video/mp4">
							<?php echo __('Your browser does not support the video tag.', 'woo-theme'); ?>
						</video>
						<span class="mask">&nbsp;</span>
					</div>
				<?php endif; ?>
				<?php if (isset($data['type']) && $data['type'] == 'articles' ):
                    if (isset($data['manual_editing']) && $data['manual_editing'] == true ) {
                        $related_posts = (isset($data['related_posts']) && !empty($data['related_posts'])) ? $data['related_posts'] : '';
                    } else {
                        $args = array(
                            'numberposts'  => 3,
                            'post_type'    => 'post',
                            'post_status'  => 'publish',
                            'order'        => 'DESC',
                            'post__not_in' => array(get_the_ID())
                        );
                        $related_posts = get_posts( $args );
                    }
                    if ($related_posts) : ?>
                        <div class="news-grid-slider">
                            <?php foreach ($related_posts as $item):
                                $image = get_featured_img_info('medium_large', $item->ID); ?>
                                <article class="news-card ">
                                    <?php if (!empty($image['src'])) :
                                        $img_alt = (!empty($image['alt'])) ? $image['alt'] : get_the_title($item->ID); ?>
                                        <div class="news-card-picture">
                                            <img src="<?php echo $image['src']; ?>" alt="<?php echo $img_alt; ?>">
                                         </div>
                                    <?php endif; ?>
                                    <div class="news-card-text">
                                        <?php $categories = get_the_terms( $item->ID, 'category' );
                                        foreach ( $categories as $category ) {
                                            if ($category->term_id != 1) {
                                                echo '<strong class="category">' . $category->name . '</strong>';
                                            }
                                        } ?>
                                        <h5 class="h5"><?php echo get_the_title($item->ID); ?></h5>
                                    </div>
                                    <a class="news-card-link"
                                       href="<?php echo get_permalink( $item->ID ); ?>">&nbsp;</a>
                                </article>
                            <?php endforeach; ?>
                        </div>
				    <?php endif;
                elseif ($data['type'] == 'products' && is_empty($data, ['related_products'])) : ?>
                    <div class="more-product-slider">
                        <?php foreach ($data['related_products'] as $item):
                            $title = '';
                            $link  = '';
                            $img_src = '';
                            if (isset($item['custom_card']) && $item['custom_card'] == true) {
                                $img_src = (isset($item['image']['sizes'])) ? $item['image']['sizes']['medium'] : '';
                                $img_alt = (isset($item['image']['alt']) && !empty($item['image']['alt'])) ? $item['image']['alt'] : '';
                                $title = (isset($item['title_link']['title']) && !empty($item['title_link']['title'])) ? $item['title_link']['title'] : '';
                                $link  = (isset($item['title_link']['url'])) ? $item['title_link']['url'] : '';
                                $target = (isset($item['title_link']['target']) && !empty($item['title_link']['target'])) ? 'target="' . $item['title_link']['target'] . '"' : '';
                            } else {
                                $post_info = get_post($item['product']);
                                $status = $post_info->post_status;
                                if ($post_info->ID != get_the_ID() && $post_info->post_status == 'publish') {
                                    $title = get_the_title($item['product']);
                                    $link  = get_the_permalink($item['product']);
                                    $target = '';
                                    $image = get_featured_img_info('single-post-thumbnail', $item['product']);
                                    $img_src = (!empty($image['src'])) ? $image['src'] : '';
                                    $img_alt = (!empty($image['alt'])) ? $image['alt'] : $title;
                                }
                            }
                            if (!empty($title) && !empty($link) && !empty($img_src)) : ?>
                                <div class="more-product-item">
                                    <div class="picture">
                                        <?php if (!empty($img_src)) : ?>
                                            <span class="icon">
                                                <img src="<?php echo $img_src; ?>" alt="<?php echo $img_alt; ?>">
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($title)) : ?>
                                        <span class="name h5"><?php echo do_excerpt($title, 45); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($link)) : ?>
                                        <a href="<?php echo $link; ?>" <?php echo $target; ?>>&nbsp;</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif;
                        endforeach; ?>
                    </div>
				<?php endif; ?>
			</div>
			<?php render( '<div class="buttons only-mobile"><div class="buttons-holder centered">', $data, 'button', '</div></div>', 'link', 'btn has-border small', '<span>', '</span>' ); ?>
		</div>
	</section>
<?php endif;
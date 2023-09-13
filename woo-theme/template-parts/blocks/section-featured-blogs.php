<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}
$classes = ['almond-industry animation'];
?>
<section class="<?php echo apply_global_classes($classes, $data); ?>">
    <div class="container">
        <div class="section-info">
            <?php render('<h2>', $data, 'title', '</h2>'); ?>
            <?php render('<p>', $data, 'text', '</p>'); ?>
        </div>
        <div class="news-holder">
            <?php foreach ($data['items'] as $index => $val) : ?>
                <?php
		            $post        = $val['post'][0];
		            $fields_post = get_field( 'fields_post', $post );
		            $class       = $index === 0 ? 'news-card full' : 'news-card';
		            $class       .= ( isset( $val['use_video'] ) && $val['use_video'] === true ) ? ' has-video' : '';

                    $media = '';

		            if ( empty( $media ) ) {
			            if ( empty( $val['image']['sizes']['full_hd'] ) ) {
				            if ( $img = get_the_post_thumbnail_url( $post, 'full' ) ) {
					            $thumbnail_id = get_post_thumbnail_id( $post );
					            $alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
					            $media        = '<img src="' . $img . '" alt="' . $alt . '">';
				            }
			            } else {
				            $media = render_image( '', $val, 'image', '', 'full_hd', '', false );
			            }
		            }
                ?>
                <article class="<?= $class; ?>">
                    <div class="news-card-picture">
                        <?= $media; ?>
	                    <button class="video-play-btn">
		                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
			                    <path fill-rule="evenodd" clip-rule="evenodd" d="M40 80C62.0914 80 80 62.0914 80 40C80 17.9086 62.0914 0 40 0C17.9086 0 0 17.9086 0 40C0 62.0914 17.9086 80 40 80ZM44.7342 31.6001L30 23.3333V56.6667L44.7342 48.2668L59.3333 40L44.7342 31.6001Z" fill="white"></path>
		                    </svg>
	                    </button>
                    </div>
                    <div class="news-card-text">
                        <h4><?php echo (!empty($val['title']) ? $val['title'] : $post->post_title); ?></h4>
                        <p><?php echo (!empty($val['excerpt']) ? $val['excerpt'] : $post->post_excerpt); ?></p>
                    </div>
                    <a class="news-card-link" href="<?= get_permalink($post); ?>">&nbsp;</a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
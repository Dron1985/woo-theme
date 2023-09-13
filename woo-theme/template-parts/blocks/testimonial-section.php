<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}
$classes = ['testimonial-section animation'];
if (isset($data['display_sub_text']) && !empty($data['display_sub_text'])) {
	$classes[] = 'about';
}

if (is_empty($data, [ 'title', 'subtitle',  'description', ' image', 'name', 'position', 'items' ])): ?>
	<section class="<?php echo apply_global_classes($classes, $data); ?>">
		<div class="container">
			<?php if (isset($data['slider']) && $data['slider'] == TRUE): ?>
				<div class="testimonial-slider">
					<?php foreach ($data['items'] as $item): ?>
						<div class="testimonial">
							<blockquote>
								<?php render( '<q>', $item, 'text', '</q>' ); ?>
								<cite><?php render( '<strong>', $item, 'author', '</strong>' ); ?>&nbsp;<?php render( '', $item, 'position', '' ); ?></cite>
							</blockquote>
							<?php render_image( '<div class="picture">', $item, 'image', '</div>', 'large' ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else:
                $title_tag = (isset($data['title_tag']) && !empty($data['title_tag'])) ? $data['title_tag'] : 'h2';?>
				<div class="testimonial">
					<div class="text">
                        <?php if (array_has_key($data, ['name'], TRUE) || array_has_key($data, ['position'], TRUE)) : ?>
                            <?php render( "<{$title_tag}>", $data, 'title', "</{$title_tag}>" ); ?>
                            <blockquote>
                                <?php render( '<q>', $data, 'description', '</q>' ); ?>
                                <cite><?php render( '<strong>', $data, 'name', '</strong>' ); ?>&nbsp;<?php render( '', $data, 'position', '' ); ?></cite>
                            </blockquote>
                        <?php else : ?>
                            <?php render( "<{$title_tag}>", $data, 'title', "</{$title_tag}>" );
                            render( '<p class="sub-text">', $data, 'sub_text', '</p>' );
                            render( '<p>', $data, 'description', '</p>' ); ?>
                        <?php endif; ?>
                        <?php if (array_has_key($data, ['button', 'url'])) : ?>
                            <div class="buttons">
                                <?php render('<div class="buttons-holder">', $data, 'button', '</div>', 'link', 'btn small', '<span>', '</span>'); ?>
                            </div>
                        <?php endif; ?>
					</div>
                    <?php if (isset($data['use_video']) && $data['use_video'] == false && isset($data['image']['sizes'])) :
                        render_image( '<div class="picture">', $data, 'image', '</div>', 'large' );
                    elseif (isset($data['use_video']) && $data['use_video'] == true && isset($data['video']['url'])) : ?>
                        <div class="video-wrap">
                            <video muted autoplay loop playsinline>
                                <source src="<?php echo $data['video']['url']; ?>" type="video/mp4" >
                                <?php echo __('Your browser does not support the video tag.', 'woo-theme'); ?>
                            </video>
                        </div>
                    <?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

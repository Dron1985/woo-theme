<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}

$classes = ['video-section animation'];
$bg_img = (isset($data['image']['sizes'])) ? 'style="background-image: url('.$data['image']['sizes']['full_hd'].');"' : '';

if (isset($data['type']) && $data['type'] == 'file' && isset($data['video']['url'])) {
    $attr_video = ' data-video="'.$data['video']['url'].'"';
} elseif (isset($data['type']) && $data['type'] == 'youtube' && isset($data['youtube_link']) && !empty($data['youtube_link'])) {
    $attr_video = ' data-video="'.$data['youtube_link'].'"';
}

if (is_empty($data, ['title', 'text', 'youtube_link', 'video'])): ?>
    <section class="<?php echo apply_global_classes($classes, $data); ?>">
        <div class="container">
            <div class="section-info large">
                <?php render('<h2>', $data, 'title', '</h2>'); ?>
                <?php render('<p>', $data, 'text', '</p>'); ?>
            </div>
            <?php if (!empty($attr_video) || !empty($bg_img)) : ?>
                <div class="video" <?php echo $attr_video.' '.$bg_img; ?>>
                    <?php if (!empty($attr_video)) : ?>
                        <button class="video-play-btn">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M40 80C62.0914 80 80 62.0914 80 40C80 17.9086 62.0914 0 40 0C17.9086 0 0 17.9086 0 40C0 62.0914 17.9086 80 40 80ZM44.7342 31.6001L30 23.3333V56.6667L44.7342 48.2668L59.3333 40L44.7342 31.6001Z" fill="white"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif;
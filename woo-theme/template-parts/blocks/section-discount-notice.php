<?php
$data = get_fields();
if ( ! $data ) {
	return;
}

if ( is_empty( $data, [ 'description animation' ] ) ): ?>
    <div class="green-divider sale">
        <div class="container">
            <?php render( '<p>', $data, 'description', '</p>' ); ?>
        </div>
        <button class="close-btn">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.4" d="M18 18L2 2M18 2L2 18" stroke="#151B20" stroke-width="1.5" stroke-linecap="square"/>
            </svg>
        </button>
    </div>
<?php endif;
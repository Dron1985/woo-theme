<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'contact-us-section animation' ];
$form_id = $data['form'];

if ( is_empty( $data, [ 'form' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="two-sides-row faq-inner">
				<div class="left-side">
					<div class="contact-info">
						<?php render( '<h4>', $data, 'title_contact', '</h4>' );
						if ( isset( $data['contact_info'] ) && ! empty( $data['contact_info'] ) && is_array( $data['contact_info'] ) && count( $data['contact_info'] ) > 0 ):
							foreach ( $data['contact_info'] as $item ): ?>
								<div class="contact-item">
									<?php render( '<span>', $item, 'title', '</span>' );
									switch ( $item['choice'] ) {
										case 'email':
											echo '<a href="mailto:' . $item["info_text"] . '">' . $item["info_text"] . '</a>';
											break;
										case 'phone':
											echo '<a href="tel:' . $item["info_text"] . '">' . $item["info_text"] . '</a>';
											break;
										case 'address':
											render( '', $item, 'info', '', 'link' );
											break;
									} ?>
								</div>
							<?php endforeach;
						endif; ?>
					</div>
					<div class="map-container">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d97595.3654143653!2d-119.24194471857408!3d35.92657659185807!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80eae7c610248b25%3A0xe91a1d29e664e740!2sTreehouse%20California%20Almonds!5e0!3m2!1sen!2s!4v1682613803824!5m2!1sen!2s" width="500" height="1000" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
				</div>
				<div class="right-side">
					<?php render( '<h4>', $data, 'title_form', '</h4>' );
					echo do_shortcode( '[contact-form-7 id="' . $form_id . '" title="Contact form 1"]' ); ?>
				</div>
			</div>
		</div>
	</section>
	<?php $list_contact = get_field( 'contact_list', 'options' ); ?>
	<script>
        window.addEventListener("load", (event) => {
            const arrayOption = new Map([
				<?php foreach ($list_contact as $key => $value): ?>
                ['<?php echo $value["select"]; ?>', '<?php echo $value["placeholder"]; ?>' ],
				<?php endforeach; ?>
            ]);
            let selectContactForm = document.querySelector('#select-contact');
            let textareaContactForm = document.querySelector('#textarea-contact');
            let placeholder = arrayOption.get(selectContactForm.value);

            selectContactForm.addEventListener('change', function () {
                let placeholder = arrayOption.get(this.value);
                textareaContactForm.placeholder = placeholder;
                //textareaContactForm.value = placeholder;
            });
        });
	</script>
<?php endif;
<div class="anh_message <?php esc_attr_e( $class ); ?>" style="margin-left: 0px;">
	<?php foreach ( $this->notices[ $type ] as $notice ) : ?>
		<p><?php echo wp_kses( $notice, wp_kses_allowed_html( 'post' ) ); ?></p>
	<?php endforeach; ?>
</div>

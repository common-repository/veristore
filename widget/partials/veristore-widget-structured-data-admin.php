<?php

/**
 * Veristore-Widget admin
 *
 * @link       http://www.veristore.de/
 * @since      1.0.0
 *
 * @package    Veristore
 * @subpackage veristore/widget/partials
 */
?>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Titel:', 'veristore' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'title' ] ); ?>">
</p>
<p>
    <input id="<?php echo $this->get_field_id( 'normal' ); ?>" class="radio" type="radio" name="<?php echo $this->get_field_name( 'font-size' ); ?>" value="normal" <?php checked( 'normal', $instance[ 'font-size' ] ); ?> />
    <label for="<?php echo $this->get_field_id( 'normal' ); ?>">
        <?php _e( 'Textgröße', 'veristore' ); ?>
    </label>
    <br />
    <input id="<?php echo $this->get_field_id( 'small' ); ?>" class="radio" type="radio" name="<?php echo $this->get_field_name( 'font-size' ); ?>" value="small" <?php checked( 'small', $instance[ 'font-size' ] ); ?> />
    <label for="<?php echo $this->get_field_id( 'small' ); ?>">
        <span style="font-size: x-small"><?php _e( 'Textgröße', 'veristore' ); ?></span>
    </label>
    <br />
    <input id="<?php echo $this->get_field_id( 'x-small' ); ?>" class="radio" type="radio" name="<?php echo $this->get_field_name( 'font-size' ); ?>" value="x-small" <?php checked( 'x-small', $instance[ 'font-size' ] ); ?> />
    <label for="<?php echo $this->get_field_id( 'x-small' ); ?>">
        <span style="font-size: xx-small"><?php _e( 'Textgröße', 'veristore' ); ?></span>
    </label>
</p>
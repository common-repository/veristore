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
    <input id="<?php echo $this->get_field_id( 'vbadgebig' ); ?>" class="radio" type="radio" name="<?php echo $this->get_field_name( 'type' ); ?>" value="vbadgebig" <?php checked( 'vbadgebig', $instance[ 'type' ] ); ?> />
    <label for="<?php echo $this->get_field_id( 'vbadgebig' ); ?>">
        <?php _e( 'Kommentar vertikal', 'veristore' ); ?>
    </label>
    <br />
    <input id="<?php echo $this->get_field_id( 'hbadgebig' ); ?>" class="radio" type="radio" name="<?php echo $this->get_field_name( 'type' ); ?>" value="hbadgebig" <?php checked( 'hbadgebig', $instance[ 'type' ] ); ?> />
    <label for="<?php echo $this->get_field_id( 'hbadgebig' ); ?>">
        <?php _e( 'Kommentar horizontal', 'veristore' ); ?>
    </label>
    <br />
    <input id="<?php echo $this->get_field_id( 'vbadgesmall' ); ?>" class="radio" type="radio" name="<?php echo $this->get_field_name( 'type' ); ?>" value="vbadgesmall" <?php checked( 'vbadgesmall', $instance[ 'type' ] ); ?> />
    <label for="<?php echo $this->get_field_id( 'vbadgesmall' ); ?>">
        <?php _e( 'ohne Kommentar', 'veristore' ); ?>
    </label>
</p>
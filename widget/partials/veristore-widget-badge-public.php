<?php

/**
 * Veristore-Widget public
 *
 * @link       http://www.veristore.de/
 * @since      1.0.0
 *
 * @package    Veristore
 * @subpackage veristore/widget/partials
 */

echo !empty( $instance['title'] ) ? $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'] : '';

?>

<a href="https://www.veristore.de/app/shop/<?php echo $this->get_option( 'vs_token' ); ?>" target="_blank"><img src="https://www.veristore.de/app/s/<?php echo $this->get_option( 'vs_token' ); ?>/<?php echo $instance[ 'type' ]; ?>.png" alt="<?php _e( 'Bewertungen einsehen', 'veristore' ); ?>"></a>

<?php

/**
 * Verisore Options Page Partials
 *
 * @link       http://www.veristore.de/
 * @since      1.0.0
 *
 * @package    Veristore
 * @subpackage veristore/admin/views/partial
 */

?>

<!-- <code>admin\views\partials\veristore-options-page-badge.php</code> -->

<p>
	<!-- <img class="alignleft" src="<?php echo plugin_dir_url( __FILE__ ); ?>../../img/siegel-100.png" alt="Veristore"> -->
    <?php printf( __( 'Mit dem integrierten Code-Generator kannst Du eine Box erstellen, in der Dein Veristore-Siegel, die durchschnittliche Bewertung und der letzte Kommentar angezeigt werden. Diese Box kannst Du dann an beliebiger Stelle auf Deiner Seite einfügen. Die Daten werden einmal am Tag aktualisiert.', 'veristore' ), '<a href="' . get_admin_url() . 'widgets.php">' . __( 'labore et dolore', 'veristore' ) . '</a>' ); ?>
</p>

<form name="form" method="post">
    <input id="_wpnonce" type="hidden" name="_wpnonce" value="<?php echo $this->nonce; ?>">
    <?php wp_referer_field(); ?>

    <table class="form-table">
        <tr>
            <th scope="row">
                <?php _e( 'Badge-Variante', 'veristore' ); ?> 
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php _e( 'Badge-Typ', 'veristore' ); ?></span>
                    </legend>
                    <p>
                        <label>
                            <input type="radio" name="vs_badge_type" value="vbadgebig" <?php checked( 'vbadgebig', $this->get_option( 'vs_badge_type' ) ); ?> />
                            <?php _e( 'Kommentar vertikal', 'veristore' ); ?>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="radio" name="vs_badge_type" value="hbadgebig" <?php checked( 'hbadgebig', $this->get_option( 'vs_badge_type' ) ); ?> />
                            <?php _e( 'Kommentar horizontal', 'veristore' ); ?>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="radio" name="vs_badge_type" value="vbadgesmall" <?php checked( 'vbadgesmall', $this->get_option( 'vs_badge_type' ) ); ?> />
                            <?php _e( 'ohne Kommentar', 'veristore' ); ?>
                        </label>
                    </p>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="vs-widget-offset">
                    <?php _e( 'Breite', 'veristore' ); ?> 
                </label>
            </th>
            <td>
                <input id="vs-badge-with" class="small-text" type="number" name="vs_badge_width" value="<?php echo $this->get_option( 'vs_badge_width' ); ?>" min="150" step="1" max="250" />
                px
            </td>
        </tr>

        <tr>
        	<th scope="row">
                    <?php _e( 'Vorschau', 'veristore' ); ?> 
            </th>
            <td>
				<div id="badge_preview"><a href="https://www.veristore.de/app/shop/<?php echo $this->get_option( 'vs_token' ); ?>" target="_blank"><img src="https://www.veristore.de/app/s/<?php echo $this->get_option( 'vs_token' ); ?>/vbadgebig.png" alt="Bewertungen einsehen" style="width: 250px"></a></div>
            </td>
        </tr>
         <tr>
        	<th scope="row">
                    <?php _e( 'Dein Veristore-Badge', 'veristore' ); ?> 
            </th>
            <td>
            	<textarea id="badge-code" name="badge-code" class="courier" readonly="true" style="width: 400px;height: 200px;"><a href="https://www.veristore.de/app/shop/<?php echo $this->get_option( 'vs_token' ); ?>" target="_blank"><img src="https://www.veristore.de/app/s/<?php echo $this->get_option( 'vs_token' ); ?>/vbadgebig.png" alt="Bewertungen einsehen" style="width: 250px"></a></textarea>
            </td>
        </tr>
    </table>

    <p class="submit">
        <input id="submit" type="submit" name="update" class="button button-primary" value="<?php esc_attr_e( 'Save Changes' ) ?>" />
    </p>

</form>


<script>

	var token = '<?php echo $this->get_option( 'vs_token' ); ?>';

	function AdjustBadge() {
		
		var width = jQuery('#vs-badge-with').val();
		var type = '' +jQuery("input[type='radio'][name='vs_badge_type']:checked").val();

		var code = '<a href="https://www.veristore.de/app/shop/' + token + '" target="_blank"><img src="https://www.veristore.de/app/s/' + token + '/' + type + '.png" alt="Bewertungen einsehen" style="width: ' + width +'"></a>';

		jQuery('#badge_preview').html(code);
		jQuery('#badge_preview img').css('width',width);
		jQuery('#badge-code').html(code);
	}

	jQuery("#vs-badge-with").change( function(e) {
        AdjustBadge();
    });

    jQuery("input[type='radio'][name='vs_badge_type']").change( function(e) {
        AdjustBadge();
    });


	jQuery(document).ready(function() {
		AdjustBadge();
	});


</script>
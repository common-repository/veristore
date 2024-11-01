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

<!-- <code>admin\views\partials\veristore-options-page-advanced.php</code> -->

<form name="form" method="post">
    <input id="_wpnonce" type="hidden" name="_wpnonce" value="<?php echo $this->nonce; ?>">
    <?php wp_referer_field(); ?>

    <table class="form-table">
        <?php if ( current_theme_supports( 'widgets' ) ) : ?>
        <tr>
            <th scope="row">
                <?php _e( 'Widgets deaktivieren', 'veristore' ); ?> 
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php _e( 'Widgets deaktivieren', 'veristore' ); ?></span>
                    </legend>
                    <p>
                        <label>
                            <input type="checkbox" name="vs_deactivate_wp_widgets" value="1" <?php checked( 1, $this->get_option( 'vs_deactivate_wp_widgets' ) ); ?> />
                            <?php _e( 'Deaktiviert alle WordPress-Widgets vom <strong>Veristore-Plugin</strong>.', 'veristore' ); ?>
                        </label>
                    </p>
                </fieldset>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <th scope="row">
                <?php _e( 'Custom-CSS', 'veristore' ); ?> 
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php _e( 'Aktivieren', 'veristore' ); ?></span>
                    </legend>
                    <p>
                        <label for="wp-widgets-css">
                            <?php _e( 'Über dieses Feld kannst Inline-CSS-Code in Deine Seite einfügen.', 'veristore' ); ?>
                        </label>
                    </p>
                    <p>
                        <textarea name="vs_inline_css" rows="10" cols="50" id="wp-widgets-css" class="large-text code"><?php echo esc_textarea( $this->get_option( 'vs_inline_css' ) ); ?></textarea>
                    </p>
                </fieldset>
            </td>
        </tr>
    </table>

    <p class="submit">
        <input id="submit" type="submit" name="update" class="button button-primary" value="<?php esc_attr_e( 'Save Changes' ) ?>" />
    </p>

</form>
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

<!-- <code>admin\views\partials\veristore-options-page-widget.php</code> -->

<form name="form" method="post">
    <input id="_wpnonce" type="hidden" name="_wpnonce" value="<?php echo $this->nonce; ?>">
    <?php wp_referer_field(); ?>

    <p>
        <?php _e( 'Das Veristore Widget ist ein Fähnchen, das am Seitenrand angezeigt wird. Du kannst zwischen zwei Größen wählen und den Abstand zum unteren Bildschirmrand einstellen.', 'veristore' ); ?>
    </p>
    <table class="form-table">
        <tr>
            <th scope="row">
                <?php _e( 'Aktivieren', 'veristore' ); ?> 
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php _e( 'Aktivieren', 'veristore' ); ?></span>
                    </legend>
                    <p>
                        <label>
                            <input type="checkbox" name="vs_widget" value="1" <?php checked( 1, $this->get_option( 'vs_widget' ) ); ?> />
                            <?php _e( 'Veristore-Widget anzeigen.', 'veristore' ); ?>
                        </label>
                    </p>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php _e( 'Strukturierte Daten verwenden', 'veristore' ); ?> 
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php _e( 'Strukturierte Daten', 'veristore' ); ?></span>
                    </legend>
                    <p>
                        <label>
                            <input type="checkbox" name="vs_structdata" value="1" <?php checked( 1, $this->get_option( 'vs_structdata' ) ); ?> />
                            <?php _e( 'Strukturierte Daten verwenden', 'veristore' ); ?>
                        </label>
                    </p>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php _e( 'Widget-Typ', 'veristore' ); ?> 
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php _e( 'Widget-Typ', 'veristore' ); ?></span>
                    </legend>
                    <p>
                        <label>
                            <input type="radio" name="vs_widget_variant" value="medium" <?php checked( 'medium', $this->get_option( 'vs_widget_variant' ) ); ?> />
                            <?php _e( 'Standard', 'veristore' ); ?>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="radio" name="vs_widget_variant" value="small" <?php checked( 'small', $this->get_option( 'vs_widget_variant' ) ); ?> />
                            <?php _e( 'Klein', 'veristore' ); ?>
                        </label>
                    </p>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php _e( 'Widget-Position', 'veristore' ); ?> 
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php _e( 'Widget-Position', 'veristore' ); ?></span>
                    </legend>
                    <p>
                        <label>
                            <input type="radio" name="vs_widget_position" value="left" <?php checked( 'left', $this->get_option( 'vs_widget_position' ) ); ?> />
                            <?php _e( 'Links', 'veristore' ); ?>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="radio" name="vs_widget_position" value="right" <?php checked( 'right', $this->get_option( 'vs_widget_position' ) ); ?> />
                            <?php _e( 'Rechts', 'veristore' ); ?>
                        </label>
                    </p>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="vs-widget-offset">
                    <?php _e( 'Abstand vom unteren Bildschirmrand', 'veristore' ); ?> 
                </label>
            </th>
            <td>
                <input id="vs-widget-offset" class="small-text" type="number" name="vs_widget_offset" value="<?php echo $this->get_option( 'vs_widget_offset' ); ?>" min="0" step="1" max="500" />
                px
            </td>
        </tr>
    </table>

    <p class="submit">
        <input id="submit" type="submit" name="update" class="button button-primary" value="<?php esc_attr_e( 'Save Changes' ) ?>" />
    </p>

</form>
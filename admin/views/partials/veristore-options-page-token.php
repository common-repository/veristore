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

<!-- <code>admin\views\partials\veristore-options-page-token.php</code> -->

<p>
    <?php _e( 'Gebe hier Dein Veristore Token ein. Dein Token findest im <a href="https://www.veristore.de/login/" target="_blank">Integrationscenter von Veristore</a>.', 'veristore' ); ?>
</p>

<form name="form" method="post">
    <input id="_wpnonce" type="hidden" name="_wpnonce" value="<?php echo $this->nonce; ?>">
    <?php wp_referer_field(); ?>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="vs-token">
                    <?php _e( 'Veristore-Token', 'veristore' ); ?> 
                </label>
            </th>
            <td>
                <input id="vs-token" type="text" name="vs_token" value="<?php echo $this->get_option( 'vs_token' ); ?>" size="20" />
            </td>
        </tr>
    </table>

    <p class="submit">
        <input id="submit" type="submit" name="update" class="button button-primary" value="<?php esc_attr_e( 'Save Changes' ) ?>" />
    </p>

</form>
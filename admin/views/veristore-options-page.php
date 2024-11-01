<?php

/**
 * Verisore Options Page
 *
 * @link       http://www.veristore.de/
 * @since      1.0.0
 *
 * @package    Veristore
 * @subpackage veristore/admin/views
 */

?>

<div class="wrap">

    <h2 class="nav-tab-wrapper">
        <a href="<?php menu_page_url( 'veristore' ); ?>" class="nav-tab<?php echo ( $this->action == 'token' ) ? ' nav-tab-active' : ''; ?>">
            <?php esc_html_e( 'Einstellungen', 'veristore' ); ?>
        </a>
        <?php if ( $this->get_option( 'vs_valid_token' ) ) : ?>
            <a href="<?php echo esc_url( add_query_arg( array( 'action' => 'widget' ) ) ); ?>" class="nav-tab<?php echo ( $this->action == 'widget' ) ? ' nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Veristore-Widget', 'veristore' ); ?>
            </a>
            <a href="<?php echo esc_url( add_query_arg( array( 'action' => 'badge' ) ) ); ?>" class="nav-tab<?php echo ( $this->action == 'badge' ) ? ' nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Veristore-Badge', 'veristore' ); ?>
            </a>
            <a href="<?php echo esc_url( add_query_arg( array( 'action' => 'advanced' ) ) ); ?>" class="nav-tab<?php echo ( $this->action == 'advanced' ) ? ' nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Erweiterte Einstellungen', 'veristore' ); ?>
            </a>
        <?php endif; ?>
    </h2>

    <?php require_once plugin_dir_path( dirname( __FILE__ ) ) . 'views/partials/veristore-options-page-' . $this->action . '.php'; ?>

</div>
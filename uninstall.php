<?php
/**
 * Runs on Uninstall of Magic robots.txt
 *
 * @package   Magic robots.txt
 * @author    ABCdatos
 * @license   GPLv2
 * @link      https://taller.abcdatos.net/robots-txt-wordpress/
 */

// Uninstall deleting used options.
// Desinstalación, borrando las opciones empleadas.

// if uninstall.php is not called by WordPress, die.
defined( 'WP_UNINSTALL_PLUGIN' ) || die( esc_html( __( 'Access is not allowed.', 'magic-robots-txt' ) ) );

require_once plugin_dir_path( __FILE__ ) . 'lista-opciones.php';

// Removes all the option values defined in the array.
foreach ( mrt_lista_opciones() as $nombre_opcion ) {
	delete_option( $nombre_opcion );
	// For site options in multisite.
	delete_site_option( $nombre_opcion );
}

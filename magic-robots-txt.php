<?php
/**
 * Plugin Name: Magic robots.txt
 * Plugin URI:  https://taller.abcdatos.net/robots-txt-wordpress/
 * Description: Manages robots access control via robots.txt
 * Version:     1.0.7
 * Author:      ABCdatos
 * Author URI:  https://taller.abcdatos.net/
 * License:     GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: magic-robots-txt
 * Domain Path: /languages
 *
 * @package magic-robots-txt
 */

defined( 'ABSPATH' ) || die( esc_html( __( 'Access is not allowed.', 'magic-robots-txt' ) ) );

/** Requerido o se obtiene error Plugin is not compatible with language packs: Missing load_plugin_textdomain(). en el canal de Slack #meta-language-packs. */
function mrt_load_plugin_textdomain() {
	load_plugin_textdomain( 'magic-robots-txt', false, basename( __DIR__ ) . '/languages' );
}
add_action( 'plugins_loaded', 'mrt_load_plugin_textdomain' );

// Valores de configuración.
require_once plugin_dir_path( __FILE__ ) . 'includes/configuracion.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/publicidad.php';
// Lista de variables usadas en tabla options.
require_once plugin_dir_path( __FILE__ ) . 'lista-opciones.php';
// Funciones sobre el contenido del archivo robots.txt.
require_once plugin_dir_path( __FILE__ ) . 'includes/robots.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mapasitio.php';
// Administration features (settings).
if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/opciones.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/archivo.php';
}

// Prioridad de Yoast SEO es 99999.
$other_robots_txt_priority = 99999;
$my_robots_txt_priority    = $other_robots_txt_priority + 1;

/** Funcionalidad del plugin modificando el contenido del robots.txt.
 *
 * @param string $robots_txt_previo Contenido previo del robots.txt.
 * @return string Nuevo contenido del robots.txt.
 */
function mrt_edita_robots_txt( $robots_txt_previo ) {
	// Trabaja tanto en archivo virtual como en real.

	// Comprobar si hay sitemap o prepara uno para agregarlo.
	$nuevo_sitemap = '';
	if ( mrt_contiene_sitemap_de_wordpress( $robots_txt_previo ) ) {
		if ( WP_DEBUG ) {
			$nuevo_sitemap .= '# Debug mode: ' . ucfirst( __( 'already have sitemap', 'magic-robots-txt' ) ) . "\n";
		}
	} elseif ( mrt_sitemaps_enabled() ) {
		$nuevo_sitemap .= 'Sitemap: ' . mrt_sitemap_wp_url() . "\n\n";
	} elseif ( WP_DEBUG ) {
		$nuevo_sitemap .= '# Debug mode: ' . ucfirst( __( 'disabled sitemap', 'magic-robots-txt' ) ) . "\n";
	}

	// Retirar el contenido estándar creado por WordPress y Yoast SEO.
	$robots_txt_previo = mrt_retira_robots_wordpress( $robots_txt_previo );
	$robots_txt_previo = mrt_retira_robots_yoast( $robots_txt_previo );

	// Contenido propio generado.
	$bloque_propio  = mrt_separador_inicio_propio();
	$bloque_propio .= mrt_robots_general();
	$bloque_propio .= mrt_robots_individuales();
	$bloque_propio .= $nuevo_sitemap;
	$bloque_propio .= mrt_separador_fin_propio();

	// Incorporación del nuevo código.
	if ( mrt_contiene_robots_propio( $robots_txt_previo ) ) {
		// Si ya había un bloque propio, lo remplaza por el contenido nuevo.
		$nuevo_robots_txt = mrt_remplaza_bloque_robots_propio( $robots_txt_previo, $bloque_propio );
	} else {
		// Si no existía, el nuevo código se agrega al final.
		if ( '/n' === $robots_txt_previo ) {
			// Si solo contiene un salto de línea tras las limpiezas anteriores, lo vacía.
			$robots_txt_previo = '';
		} elseif ( '' !== $robots_txt_previo ) {
			// Si hay contenido previo, asegura un par de saltos de línea finales antes de agregar líneas.
			if ( ! preg_match( '/\n$/', $robots_txt_previo ) ) {
				$robots_txt_previo .= "\n";
			}
			if ( ! preg_match( '/\n\n$/', $robots_txt_previo ) ) {
				$robots_txt_previo .= "\n";
			}
		}
		$nuevo_robots_txt = $robots_txt_previo . $bloque_propio;
	}

	return $nuevo_robots_txt;
}
add_filter( 'robots_txt', 'mrt_edita_robots_txt', $my_robots_txt_priority );

/** Versión del plugin para la cabecera de la página de opciones, obtenido de la cabecera de este archivo. */
function mrt_get_version() {
	// Requerido para tomar datos del plugin.
	if ( ! function_exists( 'get_plugin_data' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugin_data    = get_plugin_data( __FILE__ );
	$plugin_version = $plugin_data['Version'];
	return $plugin_version;
}

/** Título del plugin, obtenido de la cabecera de este archivo. */
function mrt_toma_nombre() {
	// Requerido para tomar datos del plugin.
	if ( ! function_exists( 'get_plugin_data' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugin_data = get_plugin_data( __FILE__ );
	$plugin_name = $plugin_data['Name'];
	return $plugin_name;
}

/**
 * Añade un enlace a la página de configuración del plugin en la página de administración de plugins.
 * Esta función crea un enlace a la página de configuración del plugin en la lista de plugins
 * de WordPress, facilitando el acceso a la configuración del plugin.
 * Basado en https://www.smashingmagazine.com/2011/03/ten-things-every-wordpress-plugin-developer-should-know/.
 *
 * @param array  $links Lista de enlaces asociados al plugin.
 * @param string $file Ruta del archivo del plugin actual.
 * @return array $links Lista de enlaces actualizada con el enlace a la página de configuración.
 */
function mrt_plugin_action_links( $links, $file ) {
	static $this_plugin;
	if ( ! $this_plugin ) {
		$this_plugin = plugin_basename( __FILE__ );
	}
	if ( $file === $this_plugin ) {
		// El valor del parámetro page es el slug de la página de opciones.
		$settings_link = '<a href="' . esc_url( admin_url( 'admin.php?page=magic-robots-txt' ) ) . '" title="' . ucfirst( __( 'plugin settings', 'magic-robots-txt' ) ) . '">' . __( 'Settings' ) . '</a>';
		array_unshift( $links, $settings_link );
	}
	return $links;
}
add_filter( 'plugin_action_links', 'mrt_plugin_action_links', 10, 2 );

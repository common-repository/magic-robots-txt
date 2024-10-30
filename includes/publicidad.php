<?php
/** Reconocimiento de uso de publicidad externa.
 *
 * @package   Magic robots.txt
 * @author    ABCdatos
 * @license   GPLv2
 * @link      https://taller.abcdatos.net/robots-txt-wordpress/
 */

defined( 'ABSPATH' ) || die( esc_html( __( 'Access is not allowed.', 'magic-robots-txt' ) ) );

/** Determina si hay algún plugin de publi conocido.
 *
 * @return int Devuelve 1 si hay algún plugin de publi conocido, 0 si no hay ninguno.
 */
function mrt_hay_plugin_publi() {
	if ( mrt_nombre_plugin_publi() ) {
		$hay_publi = 1;
	} else {
		$hay_publi = 0;
	}
	return $hay_publi;
}

/** Localiza el nombre de algún plugin de publi conocido y activo.
 *
 * @return string Devuelve el nombre del plugin de publi conocido y activo, o una cadena vacía si no hay ninguno.
 */
function mrt_nombre_plugin_publi() {
	$nombre_plugin_publi = '';
	if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugins = get_plugins();
	// Recorre los plugins existentes.
	// Para los nombres, solo se fija en los activos.
	foreach ( $plugins as $archivo_plugin => $datos_plugin ) {
		$slug_leido    = mrt_plugin_slug( $archivo_plugin );
		$nombre_plugin = mrt_plugin_activo_nombre( $slug_leido );
		if ( $nombre_plugin ) {
			if ( mrt_es_plugin_publi( $nombre_plugin ) ) {
				$nombre_plugin_publi = $nombre_plugin;
				break;
			}
		}
	}
	return $nombre_plugin_publi;
}

/** Dado el nombre completo de un plugin, determina si está relacionado con publicidad en el sitio.
 *
 * @param string $nombre_plugin El nombre completo del plugin.
 *
 * @return int Devuelve 1 si el plugin está relacionado con publicidad, 0 si no lo está.
 */
function mrt_es_plugin_publi( $nombre_plugin ) {
		$es_plugin_publi = 0;
		// Que el nombre del plugin contenga determnadas palabras es indicador de publicidad.
	if ( 'Google Listings and Ads' === $nombre_plugin ) {
		$es_plugin_publi = 0;
	} elseif (
			preg_match( "/\bad\b/i", $nombre_plugin ) ||
			preg_match( "/\bads\b/i", $nombre_plugin ) ||
			preg_match( "/\badsense\b/i", $nombre_plugin ) ||
			preg_match( "/\bmoneytizer\b/i", $nombre_plugin ) ||
			preg_match( "/\badvertising\b/i", $nombre_plugin )
		) {
		$es_plugin_publi = 1;
	}
	return $es_plugin_publi;
}

/** Indica el slug del un plugin con una ruta dada.
 * Clonada de asu_element_slug.
 *
 * @param string $ruta Ruta del plugin.
 * @return string Slug del plugin.
 */
function mrt_plugin_slug( $ruta ) {
	// Optiene el slug a partir del archivo.
	if ( stripos( $ruta, '/' ) ) {
		$slug = substr( $ruta, 0, stripos( $ruta, '/' ) );
	} elseif ( stripos( $ruta, '.php' ) ) {
		$slug = substr( $ruta, 0, stripos( $ruta, '.php' ) );
	}
	return $slug;
}

/** Indica nombre de un plugin si hay uno activo con el slug dado.
 * Basada en de asu_element_version.
 *
 * @param string $slug Slug a comprobar.
 * @return string Nombre del plugin.
 */
function mrt_plugin_activo_nombre( $slug ) {
	$local_name = '';
	if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$elements = call_user_func( 'get_plugins' );
	// Recorre los plugins activos existentes buscando el solicitado.
	foreach ( $elements as $archivo_plugin => $datos_plugin ) {
		if ( is_plugin_active( $archivo_plugin ) ) {
			$slug_leido = mrt_plugin_slug( $archivo_plugin );
			if ( $slug_leido === $slug ) {
				$local_name = $datos_plugin['Name'];
				break;
			}
		}
	}
	return $local_name;
}

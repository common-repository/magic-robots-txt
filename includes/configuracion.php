<?php
/** Valores de configuración.
 *
 * @package   Magic robots.txt
 * @author    ABCdatos
 * @license   GPLv2
 * @link      https://taller.abcdatos.net/robots-txt-wordpress/
 */

defined( 'ABSPATH' ) || die( esc_html( __( 'Access is not allowed.', 'magic-robots-txt' ) ) );

/** Versión con la que se grabó la configuración. Su existencia confirma haber usado el asistente. */
function mrt_conf_version() {
	$version = get_option( 'mrt_version', '' );
	return esc_html( $version );
}

/** Configuración avanzada */
function mrt_conf_avanzado() {
	$avanzado = get_option( 'mrt_avanzado', 0 );
	return esc_html( $avanzado );
}

// Niveles de acceso.

/** Nivel del acceso de buscadores. */
function mrt_conf_buscadores() {
	$nivel = get_option( 'mrt_buscadores', 3 );
	return esc_html( $nivel );
}

/** Nivel de la carga del servidor. */
function mrt_conf_carga() {
	// Sin valor por defecto para comprobación automática en la config.
	$carga = get_option( 'mrt_carga' );
	return esc_html( $carga );
}

/** Nivel del ahorro de recursos. */
function mrt_conf_ahorro() {
	$ahorro = get_option( 'mrt_ahorro', 3 );
	return esc_html( $ahorro );
}

/** Sitio accesible al público. */
function mrt_conf_sitio_publico() {
	// Por defecto equivale a si el sitio está activo.
	// $sitio_publico = get_option ( 'mrt_sitio_publico' , get_option ( 'blog_public' ) );
	// Por ahora quedará fuera de la BBDD, usando directamente la opción de WP.
	$sitio_publico = get_option( 'blog_public' );
	return esc_html( $sitio_publico );
}

/** El sitio vende espacios publicitarios. */
function mrt_conf_venta_publicidad() {
	// Por defecto equivale a si se detecta publi
	// Es una sobrecarga innecesaria tal vez al consultrarlo siempre, al ser solo para el robots.txt y admin es soportable.
	$venta_publicidad = get_option( 'mrt_venta_publicidad', mrt_hay_plugin_publi() );
	return esc_html( $venta_publicidad );
}

/** El sitio vende espacios enlaces. */
function mrt_conf_venta_enlaces() {
	$venta_enlaces = get_option( 'mrt_venta_enlaces', 0 );
	return esc_html( $venta_enlaces );
}

/** Utilizar un archivo robots.txt real. */
function mrt_conf_usar_archivo() {
	$usar_archivo = get_option( 'mrt_usar_archivo', mrt_usar_archivo_omision() );
	return esc_html( $usar_archivo );
}

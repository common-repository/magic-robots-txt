<?php
/** Gestión del mapa del sitio.
 *
 * @package   Magic robots.txt
 * @author    ABCdatos
 * @license   GPLv2
 * @link      https://taller.abcdatos.net/robots-txt-wordpress/
 */

defined( 'ABSPATH' ) || die( esc_html( __( 'Access is not allowed.', 'magic-robots-txt' ) ) );

/** Verifica si el contenido del robots.txt de origen contiene un sitemap dentro de WordPress.
 *
 * La función primero retira el bloque de robots propio del contenido y luego realiza una comprobación
 * utilizando una expresión regular para verificar si existe un sitemap en la URL de WordPress.
 *
 * @param string $robots_txt_previo El contenido del robots.txt original.
 *
 * @return bool Devuelve true si se encuentra un sitemap en la URL de WordPress, de lo contrario, devuelve false.
 */function mrt_contiene_sitemap_de_wordpress( $robots_txt_previo ) {
	// No ha de contar con el bloque propio o se lo quita a sí mismo.
	$robots_txt_previo   = mrt_retira_robots_propio( $robots_txt_previo );
	$url_wordpress_regex = mrt_url_wordpress_regex();
	$regex               = '/^(\b)*sitemap(\b)*:(\s|\t)*' . $url_wordpress_regex . '\w+/im';
	$contiene_sitemap    = preg_match( $regex, $robots_txt_previo );
	return (bool) $contiene_sitemap;
}

/** Regex para la URL de la instalación de WordPress. */
function mrt_url_wordpress_regex() {
	$url_wordpress = home_url( '/' );
	$regex         = mrt_convierte_a_regex( $url_wordpress );
	return $regex;
}

/** URL del sitemap en uso.
 *
 * @return string URL del sitemap.
 */
function mrt_sitemap_wp_url() {
	// Ruta del sitemap generado por WP.
	if ( mrt_sitemap_yoast_enabled() ) {
		$ruta = mrt_sitemap_yoast_url();
	} else {
		$ruta = mrt_sitemap_core_url();
	}
	return $ruta;
}

/** URL del sitemap generado por EordPress.
 *
 * @return string URL del sitemap.
 */
function mrt_sitemap_core_url() {
	// Ruta del sitemap generado por el core de WP a partir de la versión 5.5.
	$ruta = home_url( '/wp-sitemap.xml' );
	return $ruta;
}

/** URL del sitemap generado por Yoast SEO.
 *
 * @return string URL del sitemap.
 */
function mrt_sitemap_yoast_url() {
	$ruta = home_url( '/sitemap_index.xml' );
	return $ruta;
}

/** Sitemap generado por Yoast SEO activado. *
 * Entrada serializada en option_name wpseo.
 * s:18:"enable_xml_sitemap";b:1;
 * s:18:"enable_xml_sitemap";b:0;
 * Yoast SEO > General > Features > XML Sitemaps.
 *
 * @return bool Sitemap activo.
 */
function mrt_sitemap_yoast_enabled() {
	$is_enabled = 0;
	if ( is_plugin_active( 'wordpress-seo' ) ) {
		$yoast_options = get_option( 'wpseo' );
		if ( $yoast_options ) {
			$is_enabled = $yoast_options['enable_xml_sitemap'];
		}
	}
	return $is_enabled;
}

/** Sitemap generado por WordPress activado.
 * Basada en wp-includes/sitemaps/class-wp-sitemaps.php.
 * Plugins como Yoast pueden deshabilitarlo del robots.txt, puede pasar que lo que luego no lo usan en archivo físico y queda huérfano sin ninguno.
 * Falta ver si estando en subdir hace algo.
 *
 * @return bool Sitemap activo.
 */
function mrt_sitemaps_enabled() {
	$is_enabled = (bool) get_option( 'blog_public' );
	$is_enabled = (bool) apply_filters( 'wp_sitemaps_enabled', $is_enabled );
	$is_enabled = $is_enabled || mrt_sitemap_yoast_enabled();
	return $is_enabled;
}

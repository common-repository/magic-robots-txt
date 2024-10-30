<?php
/**
 * Lista de opciones guardadas en la base de datos para configuración y desinstalación.
 *
 * @package   Magic robots.txt
 * @author    ABCdatos
 * @license   GPLv2
 * @link      https://taller.abcdatos.net/robots-txt-wordpress/
 */

defined( 'ABSPATH' ) || die( esc_html( __( 'Access is not allowed.', 'magic-robots-txt' ) ) );

/** Lista de variables usadas en tabla options. */
function mrt_lista_opciones() {
	return array(
		'mrt_version',
		'mrt_avanzado',
		'mrt_buscadores',
		'mrt_redes_publicidad',
		'mrt_analizadores_enlaces',
		'mrt_descargadores',
		'mrt_carga',
		'mrt_ahorro',
		'mrt_venta_publicidad',
		'mrt_venta_enlaces',
		'mrt_usar_archivo',
	);
}

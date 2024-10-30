<?php
/** Operaciones sobre un archivo robots.txt real.
 *
 * @package   Magic robots.txt
 * @author    ABCdatos
 * @license   GPLv2
 * @link      https://taller.abcdatos.net/robots-txt-wordpress/
 */

defined( 'ABSPATH' ) || die( esc_html( __( 'Access is not allowed.', 'magic-robots-txt' ) ) );

// Operaciones sobre el archivo robots.txt físico.

/** Indica si es escribible el directorio donde ha de ubicarse el archivo robots.txt. */
function mrt_escribible_directorio_robots() {
	$ruta       = mrt_ruta_directorio_robots();
	$escribible = wp_is_writable( $ruta );
	return $escribible;
}

/** Indica si es escribible el archivo robots.txt. */
function mrt_escribible_archivo_robots() {
	$ruta       = mrt_ruta_archivo_robots();
	$escribible = wp_is_writable( $ruta );
	return $escribible;
}

/** Indica si es legible el archivo robots.txt. */
function mrt_legible_archivo_robots() {
	$ruta    = mrt_ruta_archivo_robots();
	$legible = is_readable( $ruta );
	return $legible;
}

/** Indica si existe el archivo robots.txt. */
function mrt_existe_archivo_robots() {
	$ruta   = mrt_ruta_archivo_robots();
	$existe = file_exists( $ruta );
	return $existe;
}

/** Indica si es utilizable el archivo robots.txt.
 * Para ello requiere que sea legible y escribible.
 */
function mrt_utilizable_archivo_robots() {
	$ruta = mrt_ruta_archivo_robots();
	if ( mrt_existe_archivo_robots() ) {
		$utilizable = mrt_legible_archivo_robots() && mrt_escribible_archivo_robots();
	} else {
		$utilizable = mrt_escribible_directorio_robots();
	}
	return $utilizable;
}

/** Devuelve el contenido del archivo robots.txt.
 *
 * @return string Contenido del archivo real robots.txt.
 */
function mrt_lee_archivo_robots() {
	$ruta = mrt_ruta_archivo_robots();

	/*
	Remplazada la línea:
	$contenido = file_get_contents( $ruta );
	para usar funciones de WP.
	*/
	global $wp_filesystem;
	if ( ! $wp_filesystem ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
	}
	$contenido = $wp_filesystem->get_contents( $ruta );

	return $contenido;
}

/**
 * Graba el contenido del archivo robots.txt.
 *
 * @param string $contenido Contenido para el archivo real robots.txt.
 */
function mrt_graba_archivo_robots( $contenido ) {
	$ruta = mrt_ruta_archivo_robots();

	/*
	Remplazada la línea:
	$resultado = file_put_contents( $ruta, $contenido );
	para usar funciones de WP.
	*/
	global $wp_filesystem;
	if ( ! $wp_filesystem ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
	}
	$resultado = $wp_filesystem->put_contents( $ruta, $contenido );

	return $resultado;
}

/** Devuelve la ruta del archivo robots.txt.
 *
 * @return string Ruta del archivo real robots.txt.
 */
function mrt_ruta_archivo_robots() {
	$ruta = mrt_directorio_web() . 'robots.txt';
	return $ruta;
}

/** Ruta raíz de la instalación indicada por WordPress
 *
 * @return string Ruta, incluye la /
 */
function mrt_directorio_wp() {
	$ruta = ABSPATH;
	return $ruta;
}

/** Ruta raíz del dominio indicada por el servidor.
 *
 * @return string Ruta, incluye la /.
 */
function mrt_directorio_web() {
	$ruta = mrt_ruta_directorio_robots();

	if ( $ruta ) {
		$ruta .= '/';
	} else {
		// Si no la puede determinar, mejor tomar el directorio de WP como último recurso.
		$ruta = mrt_directorio_wp();
	}
	return $ruta;
}

/** Ruta raíz del dominio indicada por el servidor.
 *
 * @return string Ruta, sin incluir la /.
 */
function mrt_ruta_directorio_robots() {
	$ruta = '';
	if ( isset( $_SERVER['DOCUMENT_ROOT'] ) ) {
		$ruta = sanitize_text_field( wp_unslash( $_SERVER['DOCUMENT_ROOT'] ) );
		// Podría prepararlo para Windows con: $ruta = wp_normalize_path( $_SERVER['DOCUMENT_ROOT'] );
		// Valida el contenido, que es simplemente empezar por /, solo será válido en sistemas de archivos Unix.
		$regex = '/^\//';
		if ( ! preg_match( $regex, $ruta ) ) {
			$ruta = '';
		}
	}
	return $ruta;
}

/** Determina si hay que usar archivo en las condiciones actuales */
function mrt_usar_archivo() {
	$usar_archivo = mrt_usar_archivo_omision();
	if ( ! mrt_usar_archivo_omision() ) {
		$usar_archivo = mrt_conf_usar_archivo();
	}
	return $usar_archivo;
}

/** Determina el valor por omisión al uso de archivo.
 *
 * @return int 1 si es obligatorio o existe.
 */
function mrt_usar_archivo_omision() {
	$usar_archivo = mrt_usar_archivo_forzoso();
	if ( mrt_existe_archivo_robots() ) {
		$usar_archivo = 1;
	}
	return $usar_archivo;
}

/** Determina si no hay otra alternativa a usar archivo.
 *
 * @return int 1 si es obligatorio.
 */
function mrt_usar_archivo_forzoso() {
	$usar_archivo = 0;

	// Comprueba si el directorio de instalación de WordPress difiere del directorio raíz del sitio web.
	if ( mrt_directorio_web() !== mrt_directorio_wp() ) {
		$usar_archivo = 1;
	}

	// Verifica si el URL del sitio comienza con 'https://playground.wordpress.net/'.
	if ( 0 === strpos( home_url(), 'https://playground.wordpress.net/' ) ) {
		$usar_archivo = 1;
	}
	return $usar_archivo;
}

/** Crea el contenido del aviso cuando el plugin ha de operar el archivo robots.txt real y no puede.
 *
 * @return string HTML con el aviso.
 */
function mrt_html_problemas_archivo_robots() {
	$aviso_problema = '';
	$solucion       = '';
	$html           = '';
	// Advertir si se ha seleccionado el virtual y hay real sin que sea forzoso.
	if (
		( ! get_option( 'mrt_usar_archivo', 1 ) )
		&& mrt_existe_archivo_robots()
		&& ( ! mrt_usar_archivo_forzoso() )
	) {
		$aviso_problema .= '<li>';
		/* translators: %s: file path */
		$aviso_problema .= ucfirst( sprintf( __( 'there is a file <b>%s</b> preventing to use the configured virtual robots.txt', 'magic-robots-txt' ), esc_html( mrt_ruta_archivo_robots() ) ) ) . '.<br />';
		$aviso_problema .= "</li>\n";
		/* translators: %s: file path */
		$solucion = sprintf( __( 'you may either remove the <b>%s</b> file to use the virtual one or choose to use the real file', 'magic-robots-txt' ), esc_html( mrt_ruta_archivo_robots() ) );
	} elseif ( ! mrt_utilizable_archivo_robots() ) {
		if ( mrt_usar_archivo_forzoso() ) {
			$aviso_problema .= '<li>';
			$aviso_problema .= ucfirst( __( 'this site must use a real robots.txt file, there are no option to use a virtual file', 'magic-robots-txt' ) ) . '.<br />';
			$aviso_problema .= "</li>\n";
		}
		if ( mrt_existe_archivo_robots() ) {
			if ( ( ! mrt_legible_archivo_robots() ) || ( ! mrt_escribible_archivo_robots() ) ) {
				if ( ! mrt_legible_archivo_robots() ) {
					$aviso_problema .= '<li>';
					/* translators: %s: file path */
					$aviso_problema .= ucfirst( sprintf( __( 'file <b>%s</b> is not readable by the plugin', 'magic-robots-txt' ), esc_html( mrt_ruta_archivo_robots() ) ) ) . '.<br />';
					$aviso_problema .= "</li>\n";
				} elseif ( ! mrt_escribible_archivo_robots() ) {
					$aviso_problema .= '<li>';
					/* translators: %s: file path */
					$aviso_problema .= ucfirst( sprintf( __( 'file <b>%s</b> is not writable by the plugin', 'magic-robots-txt' ), esc_html( mrt_ruta_archivo_robots() ) ) ) . '.<br />';
					$aviso_problema .= "</li>\n";
				}
				/* translators: %s: file path */
				$solucion = sprintf( __( 'give read and write permissions to the PHP user to the <b>%s</b> file', 'magic-robots-txt' ), esc_html( mrt_ruta_archivo_robots() ) );
				if ( ! mrt_usar_archivo_forzoso() ) {
					$solucion .= ' ' . __( 'or delete it and configure to use virtual robots.txt file', 'magic-robots-txt' );
				}
			}
		} else {
			$aviso_problema .= '<li>';
			/* translators: %1$s: file path, %2$s: directory path. */
			$aviso_problema .= ucfirst( sprintf( __( 'the file <b>%1$s</b> does not exists and the plugin has not permissions in the directory <b>%2$s</b> to create the robots.txt file', 'magic-robots-txt' ), esc_html( mrt_ruta_archivo_robots() ), esc_html( mrt_ruta_directorio_robots() ) ) ) . '.<br />';
			$aviso_problema .= "</li>\n";
			/* translators: %1$s: directory path, %2$s: file path. */
			$solucion = sprintf( __( 'you may either give permissions to the PHP user to write in the <b>%1$s</b> directory or create an empty <b>%2$s</b> file with proper permissions to read and write it', 'magic-robots-txt' ), esc_html( mrt_ruta_directorio_robots() ), esc_html( mrt_ruta_archivo_robots() ) );
			if ( ! mrt_usar_archivo_forzoso() ) {
				$solucion .= ' ' . __( 'or select to use virtual robots.txt file', 'magic-robots-txt' );
			}
		}
	}
	if ( $aviso_problema ) {
		$html .= '<p style="font-weight:bold;">⚠ ';
		$html .= ucfirst( __( 'there are problems to operate the robots.txt file.', 'magic-robots-txt' ) ) . '.</p>';
		$html .= "<ul>\n";
		$html .= $aviso_problema;
		$html .= '</ul>';
		if ( $solucion ) {
			$html .= '<b>';
			$html .= ucfirst( __( 'solution', 'magic-robots-txt' ) );
			$html .= ':</b> ';
			$html .= $solucion;
			$html .= '.';
		}
	}
	return $html;
}

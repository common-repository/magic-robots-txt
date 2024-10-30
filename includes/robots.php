<?php
/** Proporciona los bloques de código de cada tipo de robot.
 *
 * @package   Magic robots.txt
 * @author    ABCdatos
 * @license   GPLv2
 * @link      https://taller.abcdatos.net/robots-txt-wordpress/
 */

defined( 'ABSPATH' ) || die( esc_html( __( 'Access is not allowed.', 'magic-robots-txt' ) ) );


/** Devuelve el contenido del bloque de robots general.
 *
 * @return string Bloque de contenido para el robots.txt.
 */
function mrt_robots_general() {
	$tipo_robot = 0;
	$robot      = '*';
	$accion     = mrt_accion_robot( $tipo_robot );
	if ( mrt_conf_sitio_publico() ) {
		$allow = mrt_acceso( $accion );
		// No está contemplando la presencia en subdirectorios.
		$allow .= ',' . mrt_subdirectorio_wp() . '/wp-admin/admin-ajax.php';
		// Los directorios de temas y plugins podrían contener CSS o JS que hay que leer.
		$disallow = mrt_subdirectorio_wp() . '/wp-admin/,' . mrt_subdirectorio_wp() . '/readme.html$';
	} else {
		$disallow = mrt_bloqueo( $accion );
	}
	$crawl_delay       = 0;
	$bloque_robots_txt = mrt_bloque_robot( $robot, $crawl_delay, $disallow, $allow );
	$bloque_robots_txt = '# ' . ucfirst( __( 'general', 'magic-robots-txt' ) ) . "\n$bloque_robots_txt\n";
	return $bloque_robots_txt;
}

/** Bloque de cada robot individual si corresponde.
 *
 * @return string Bloque de contenido para el robots.txt.
 */
function mrt_robots_individuales() {
	$conjunto_robots_txt = '';
	$accion_general      = mrt_accion_robot( 0 );
	// Prepara un bloque por cada tipo de robots si corresponde.
	for ( $tipo_robot = 1; $tipo_robot <= 4; $tipo_robot++ ) {
		$bloque_robots_txt = '';
		$lista_robots      = mrt_lista_robots( $tipo_robot );
		$accion            = mrt_accion_robot( $tipo_robot );
		// Comentarios adicionales en el archivo de salida con al acción sobre cada tipo de robot.
		if ( WP_DEBUG ) {
			$bloque_robots_txt .= '# Debug mode: ' . mrt_denominacion_tipo_robots( $tipo_robot ) . ' -> ' . mrt_denominacion_accion( mrt_accion_robot( $tipo_robot, mrt_conf_carga(), mrt_conf_ahorro() ) ) . "\n";
		}
		// Actuar si la acción es diferente a la general.
		if ( $accion !== $accion_general ) {
			$crawl_delay        = mrt_retraso( $accion );
			$disallow           = mrt_bloqueo( $accion );
			$allow              = mrt_acceso( $accion );
			$bloque_robots_txt .= mrt_bloque_robots( $lista_robots, $crawl_delay, $disallow, $allow );
			// Agrega el bloque si tiene contenido, que solo sucederá si es diferente al tipo general.
			if ( $bloque_robots_txt ) {
				$bloque_robots_txt = '# ' . ucfirst( mrt_denominacion_tipo_robots( $tipo_robot ) ) . "\n$bloque_robots_txt\n";
			}
		}
		// Agrega el bloque al conjunto.
		$conjunto_robots_txt .= $bloque_robots_txt;
	}
	return $conjunto_robots_txt;
}

/** Devuelve el bloque de una lista de robots configurados todos ellos con las características indicadas.
 *
 * @param string $lista_robots Lista separada por comas con los identificadores de los robots a aplicar.
 * @param int    $crawl_delay Demora en segundos a aplicar. Por defecto 0.
 * @param string $disallow Deshabilitar vuertas rutas. Por defecto ''.
 * @param string $allow Permitir ciertas rutas. Por defecto ''.
 * @return string Bloque de contenido para el robots.txt.
 */
function mrt_bloque_robots( $lista_robots, $crawl_delay = 0, $disallow = '', $allow = '' ) {
	$bloque_robots = '';
	if ( $lista_robots ) {
		$robots = explode( ',', $lista_robots );
		foreach ( $robots as $robot ) {
			$bloque_robots .= mrt_bloque_robot( $robot, $crawl_delay, $disallow, $allow );
		}
	}
	return $bloque_robots;
}

/** Devuelve el bloque de un robot configurado con las características indicadas.
 *
 * @param string $user_agent Identificador del robot a aplicar.
 * @param int    $crawl_delay Demora en segundos a aplicar. Por defecto 0.
 * @param string $disallow Deshabilitar vuertas rutas. Por defecto ''.
 * @param string $allow Permitir ciertas rutas. Por defecto ''.
 * @return string Bloque de contenido para el robots.txt.
 */
function mrt_bloque_robot( $user_agent, $crawl_delay = 0, $disallow = '', $allow = '' ) {
	// El bloque solo tiene sentido si cambia algo respecto al general o es el general.
	$user_agent     = trim( $user_agent );
	$accion_general = mrt_accion_robot( 0 );
	if (
		'*' === $user_agent
		|| mrt_retraso( $accion_general ) !== $crawl_delay
		|| mrt_bloqueo( $accion_general ) !== $disallow
		|| $allow
	) {
		$bloque_robot = "User-agent: $user_agent\n";
		if ( $allow ) {
			$rastreables = explode( ',', $allow );
			foreach ( $rastreables as $rastrear ) {
				$bloque_robot .= "Allow: $rastrear\n";
			}
		}
		// Lo publica si tinene valor distinto del general o es el general.
		if (
			'*' === $user_agent
			|| mrt_bloqueo( $accion_general ) !== $disallow
		) {
			$desactivables = explode( ',', $disallow );
			foreach ( $desactivables as $desactivar ) {
				$bloque_robot .= "Disallow: $desactivar\n";
			}
		}
		// Lo publica si tinene valor distinto del general o es el general y hay valor.
		if (
			( '*' === $user_agent && $crawl_delay )
			|| mrt_retraso( $accion_general ) !== $crawl_delay
		) {
			$bloque_robot .= "Crawl-Delay: $crawl_delay\n";
		}
	} else {
		$bloque_robot = '';
	}
	return $bloque_robot;
}

/** Devuelve el código de la acción a realizar con un tipo de robot determinado.
 * La acción viene dada por la relación beneficio/coste
 * basada en el tipo de robot y la configuración del plugin.
 *
 * @param int $tipo_robot Código numérico del tipo de robots pretendido.
 * @return int Código de 0 a 3 de la acción a realizar.
 */
function mrt_accion_robot( $tipo_robot ) {
	// 0 permitir
	// 1 calmar
	// 2 domesticar
	// 3 bloquear
	$accion = intval( mrt_conf_carga() ) + intval( mrt_conf_ahorro() ) - intval( mrt_interes_robot( $tipo_robot ) ) - 1;
	if ( $accion < 0 ) {
		$accion = 0;
	} elseif ( $accion > 3 ) {
		$accion = 3;
	}
	return $accion;
}

/** Devuelve la denominación traducida correspondiente al código de una acción determinada.
 *
 * @param int $accion Código numérico de la acción.
 * @return string Denominación en minúsculas en el idioma local.
 */
function mrt_denominacion_accion( $accion ) {
	switch ( $accion ) {
		case 3:
			/* translators: verb */
			$texto = __( 'block', 'magic-robots-txt' );
			break;
		case 2:
			$texto = __( 'tame', 'magic-robots-txt' );
			break;
		case 1:
			$texto = __( 'calm', 'magic-robots-txt' );
			break;
		case 0:
			$texto = __( 'allow', 'magic-robots-txt' );
			break;
		default:
			// Condición de error. Tipo de robot imprevisto.
			$texto = __( 'action type', 'magic-robots-txt' ) . ' ' . __( 'unknown', 'magic-robots-txt' ) . ' (' . $accion . ')';
	}
	return $texto;
}

/** Devuelve el valor de retraso a aplicar al parámetro Crawl-Delay correspondiente a una acción determinada.
 *
 * @param int $accion Código numérico de la acción.
 * @return int Retraso a aplicar en segundos.
 */
function mrt_retraso( $accion ) {
	if ( 1 === $accion ) {
		$crawl_delay = 1;
	} elseif ( 2 === $accion ) {
		$crawl_delay = 5;
	} else {
		// Si se permite o se bloquea, no hay atraso.
		$crawl_delay = 0;
	}
	return $crawl_delay;
}

/** Devuelve la ruta a bloquear si la hubiera para aplicar al parámetro Disallow en base a la acción.
 *
 * @param int $accion Código numérico de la acción.
 * @return string Ruta a aplicar o cadena vacía.
 */
function mrt_bloqueo( $accion ) {
	if ( 3 === $accion ) {
		$disallow = mrt_subdirectorio_wp() . '/';
	} else {
		$disallow = '';
	}
	return $disallow;
}

/** Devuelve la ruta a admitir si la hubiera para aplicar al parámetro Allow en base a la acción.
 *
 * @param int $accion Código numérico de la acción.
 * @return string Ruta a aplicar o cadena vacía.
 */
function mrt_acceso( $accion ) {
	if ( 0 === $accion ) {
		$allow = mrt_subdirectorio_wp() . '/';
	} else {
		$allow = '';
	}
	return $allow;
}

/** Devuelve un número valorando el interés que tiene para el usuario un tipo de robots concreto.
 * El interés por un robot viene dado por la relación beneficio/coste
 * basado en el tipo de robot y la configuración del plugin.
 *
 * @param int $tipo_robot Código numérico del tipo de robots pretendido.
 * @return int Valoración de 0 a 5 del interés del usuario. A más bajo el número, más interesado.
 */
function mrt_interes_robot( $tipo_robot ) {
	$interes = 0;
	switch ( $tipo_robot ) {
		case 0:
			if ( mrt_conf_sitio_publico() ) {
				$interes = 5;
			}
			break;
		case 1:
			if ( mrt_conf_sitio_publico() ) {
				$interes = 5;
			}
			break;
		case 2:
			if ( mrt_conf_venta_publicidad() ) {
				$interes = 4;
			}
			break;
		case 3:
			if ( mrt_conf_venta_enlaces() ) {
				$interes = 3;
			}
			break;
		case 4:
			$interes = 0;
			break;
		default:
			// Condición de error. Tipo de robot imprevisto.
	}
	return $interes;
}

/** Devuelve el texto traducido del tipo de robots consultado numéricamente.
 *
 * @param int $tipo_robot Código numérico del tipo de robots pretendido.
 * @return string Denominación traducida del tipo de robots afecados.
 */
function mrt_denominacion_tipo_robots( $tipo_robot ) {
	switch ( $tipo_robot ) {
		case 0:
			$texto = __( 'general', 'magic-robots-txt' );
			break;
		case 1:
			$texto = __( 'search engines', 'magic-robots-txt' );
			break;
		case 2:
			$texto = __( 'ad networks', 'magic-robots-txt' );
			break;
		case 3:
			$texto = __( 'link analyzers', 'magic-robots-txt' );
			break;
		case 4:
			// Abusive.
			$texto = __( 'downloaders', 'magic-robots-txt' );
			break;
		default:
			// Condición de error. Tipo de robot imprevisto.
			$texto = __( 'unknown', 'magic-robots-txt' );
	}
	return $texto;
}

/** Devuelve una lista separada por comas de los User-Agent de un tipo de ronbots.
 *
 * @param int $tipo_robot Código numérico del tipo de robots pretendido.
 * @return string Lista de user-agent separada por comas.
 */
function mrt_lista_robots( $tipo_robot ) {
	switch ( $tipo_robot ) {
		case 0:
			$lista_robots = '*';
			break;
		case 1:
			$lista_robots = 'Googlebot,Googlebot-News,Googlebot-Image,Googlebot-Video,Bingbot,Slurp,DuckDuckBot,Baiduspider,YandexBot,Applebot,ia_archiver,MojeekBot,PetalBot,SeekportBot,Neevabot,Owler@ows.eu/1Owler@ows.eu/2,Owler@ows.eu/X,netEstate NE Crawler';
			break;
		case 2:
			$lista_robots = 'Mediapartners-Google,AdsBot-Google,proximic,CriteoBot/0.1,grapeshot';
			break;
		case 3:
			$lista_robots = 'AhrefsBot,SemrushBot,MJ12Bot,dotbot,BLEXBot,serpstatbot,DataForSeoBot,omgilibot,barkrowler';
			break;
		case 4:
			$lista_robots = 'webreaper,MSIECrawler,WebCopier,HTTrack,VelenPublicWebCrawler,AwarioBot,AwarioRssBot,AwarioSmartBot,Amazonbot';
			break;
		default:
			// Condición de error. Tipo de robot imprevisto.
			$lista_robots = 'Unknown robot type error';
	}
	return $lista_robots;
}

/** Retira el bloque de WordPress habitual de un contenido de robots.txt dado.
 *
 * @param string $robots_txt_previo Contenido de robots.txt inicial.
 * @return string Contenido de robots.txt procesado.
 */
function mrt_retira_robots_wordpress( $robots_txt_previo ) {
	$robots_txt = str_replace(
		mrt_robots_general_wordpress(),
		'',
		$robots_txt_previo
	);
	$robots_txt = trim( $robots_txt );
	if ( '' !== $robots_txt ) {
		$robots_txt .= "\n";
	}
	return $robots_txt;
}

/** Retira el bloque de Yoast de un contenido de robots.txt dado.
 *
 * @param string $robots_txt_previo Contenido de robots.txt inicial.
 * @return string Contenido de robots.txt procesado.
 */
function mrt_retira_robots_yoast( $robots_txt_previo ) {
	$robots_txt = str_replace(
		mrt_robots_general_yoast(),
		'',
		$robots_txt_previo
	);
	$robots_txt = trim( $robots_txt );
	if ( '' !== $robots_txt ) {
		$robots_txt .= "\n";
	}
	return $robots_txt;
}

/** Informa si un contenido de robots.txt dado contiene bloque propio.
 *
 * @param string $robots_txt_previo Contenido de robots.txt inicial.
 * @return int 0 Si no contiene el bloque propio, 1 si lo contiene.
 */
function mrt_contiene_robots_propio( $robots_txt_previo ) {
	$regex    = '/' . mrt_bloque_robots_propio_regex() . '/s';
	$contiene = preg_match( $regex, $robots_txt_previo );
	return $contiene;
}

/** Retira el bloque propio de un contenido de robots.txt dado.
 *
 * @param string $robots_txt_previo Contenido de robots.txt inicial.
 * @return string Contenido de robots.txt procesado.
 */
function mrt_retira_robots_propio( $robots_txt_previo ) {
	$regex      = '/' . mrt_bloque_robots_propio_regex() . '/s';
	$robots_txt = preg_replace( $regex, '', $robots_txt_previo );
	$robots_txt = trim( $robots_txt );
	if ( '' !== $robots_txt ) {
		$robots_txt .= "\n";
	}
	return $robots_txt;
}

/** Remplaza el bloque propio por uno nuevo.
 *
 * @param string $robots_txt_previo Contenido de robots.txt inicial.
 * @param string $bloque_propio_robots_txt Contenido del bloque propio nuevo para incorporar.
 * @return string Contenido de robots.txt procesado.
 */
function mrt_remplaza_bloque_robots_propio( $robots_txt_previo, $bloque_propio_robots_txt ) {
	// Para que el punto incluya los saltos de línea, requiere el modificador 's'.
	$regex      = '/' . mrt_bloque_robots_propio_regex() . '/s';
	$robots_txt = preg_replace( $regex, $bloque_propio_robots_txt, $robots_txt_previo );
	$robots_txt = trim( $robots_txt );
	if ( '' !== $robots_txt ) {
		$robots_txt .= "\n";
	}
	return $robots_txt;
}

/** Crea la regex que cubre el bloque de robots propio. */
function mrt_bloque_robots_propio_regex() {
	$regex  = mrt_separador_inicio_propio_regex();
	$regex .= '(.*)';
	$regex .= mrt_separador_fin_propio_regex();
	return $regex;
}

/** Cabecera del bloque propio. */
function mrt_separador_inicio_propio() {
	$separador  = '# BEGIN ' . mrt_toma_nombre() . "\n";
	$separador .= mrt_separador_guiones_propio();
	$separador .= "\n";
	return $separador;
}

/** Versión regex de la cabecera del bloque propio. */
function mrt_separador_inicio_propio_regex() {
	return mrt_convierte_a_regex( mrt_separador_inicio_propio() );
}

/** Fin del bloque propio. */
function mrt_separador_fin_propio() {
	$separador  = mrt_separador_guiones_propio();
	$separador .= '# END ' . mrt_toma_nombre() . "\n";
	return $separador;
}

/** Versión regex del fin del bloque propio. */
function mrt_separador_fin_propio_regex() {
	return mrt_convierte_a_regex( mrt_separador_fin_propio() );
}

/** Guiones que forman el fin de la cabecera o inicio del fin. */
function mrt_separador_guiones_propio() {
	// Cuando se usa en el inicio, va con un salto de línea adicional.
	$separador = "# ---------------------------\n";
	return $separador;
}

/** Contenido estándar del robots.txt de WordPress. */
function mrt_robots_general_wordpress() {
	return "User-agent: *\nDisallow: /wp-admin/\nAllow: /wp-admin/admin-ajax.php\n";
}

/** Contenido estándar del robots.txt de Yoast. */
function mrt_robots_general_yoast() {
	return "User-agent: *\nDisallow:\n\n";
}

/** Convierte en regex una cadena.
 *
 * @param string $cadena Ruta del archivo del plugin actual.
 */
function mrt_convierte_a_regex( $cadena ) {
	$regex = preg_quote( $cadena, '/' );
	return $regex;
}

/** Subdirectorio desde el raíz web de la instalación indicada por WordPress, sin la / final
 * En caso de subdirectorio: /blog
 * En caso de no subdirectorio: [vacío]
 *
 * @return string Ruta del sitio WP.
 */
function mrt_subdirectorio_wp() {
	$ruta = wp_parse_url( site_url(), PHP_URL_PATH );
	return $ruta;
}

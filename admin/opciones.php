<?php
/** Gestión de las opciones del panel de administración
 *
 * @package   Magic robots.txt
 * @author    ABCdatos
 * @license   GPLv2
 * @link      https://taller.abcdatos.net/robots-txt-wordpress/
 */

defined( 'ABSPATH' ) || die( esc_html( __( 'Access is not allowed.', 'magic-robots-txt' ) ) );

/** Entrada del menú de administración. */
function mrt_add_admin_menu() {

	if ( mrt_html_problemas_archivo_robots() ) {
		$contenido_notificacion  = '⚠ ';
		$contenido_notificacion .= ucfirst( __( 'attention', 'magic-robots-txt' ) );
		$notificacion_globo      = " <span class=\"awaiting-mod\">$contenido_notificacion</span>";
	} elseif ( ! mrt_conf_version() ) {
		// Está pendiente de configuración.
		$contenido_notificacion  = '⚠ ';
		$contenido_notificacion .= ucfirst( __( 'configure it', 'magic-robots-txt' ) );
		$notificacion_globo      = " <span class=\"awaiting-mod\">$contenido_notificacion</span>";
	} else {
		$notificacion_globo = '';
	}

	// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Base64 encoding used for SVG icon; considered safe.
	$icono_base64 = base64_encode( '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 511.999 511.999" style="fill:#a7aaad" xml:space="preserve"><g><g><path d="M424.464,226.038h-31.289c-4.637,0-8.394,3.758-8.394,8.394v17.485H370.51v-17.485c0-4.636-3.757-8.394-8.394-8.394h-34.743v-17.351h34.743c4.637,0,8.394-3.758,8.394-8.394V66.121c0-20.285-16.502-36.787-36.787-36.787h-69.329V8.394c0-4.636-3.757-8.394-8.394-8.394c-4.637,0-8.394,3.758-8.394,8.394v20.939h-69.33c-20.285,0-36.787,16.503-36.787,36.787v134.173c0,4.636,3.757,8.394,8.394,8.394h34.744v17.351h-34.744c-4.637,0-8.394,3.758-8.394,8.394v17.485h-14.271v-17.485c0-4.636-3.757-8.394-8.394-8.394h-31.29c-4.637,0-8.394,3.758-8.394,8.394v169.096c0,4.636,3.757,8.394,8.394,8.394h31.289c4.637,0,8.394-3.758,8.394-8.394V303.215h14.271v68.203c0,4.636,3.757,8.394,8.394,8.394h14.9v75.713h-10.586c-4.637,0-8.394,3.758-8.394,8.394v39.686c0,4.636,3.757,8.394,8.394,8.394h70.744c4.637,0,8.394-3.758,8.394-8.394v-39.686c0-4.636-3.757-8.394-8.394-8.394h-10.585v-75.713h83.289v75.713h-10.586c-4.637,0-8.394,3.758-8.394,8.394v39.686c0,4.636,3.757,8.394,8.394,8.394h70.744c4.637,0,8.394-3.758,8.394-8.394v-39.686c0-4.636-3.757-8.394-8.394-8.394h-10.585v-75.713h14.9c4.637,0,8.394-3.758,8.394-8.394v-68.203h14.271v100.312c0,4.636,3.757,8.394,8.394,8.394h31.289c4.637,0,8.394-3.758,8.394-8.394V234.431C432.857,229.796,429.1,226.038,424.464,226.038z M110.43,395.134H95.929V242.826h14.501V395.134z M141.489,286.428h-14.271v-17.723h14.271V286.428z M158.276,191.9V66.121c0-11.028,8.972-20,20-20h155.447c11.028,0,20,8.972,20,20V191.9H158.276z M310.586,208.686v17.351H201.414v-17.351H310.586z M216.547,472.314v22.898h-53.957v-22.898H216.547z M181.571,455.526v-75.713h15.998v75.713H181.571z M349.409,472.314v22.898h-53.957v-22.898H349.409zM314.433,455.526v-75.713h15.998v75.713h0H314.433z M353.723,363.024H158.276V242.826h195.446V363.024z M384.781,286.428H370.51v-17.723h14.271V286.428z M416.07,395.134h-14.501V242.826h14.501V395.134z"/></g></g><g><g><path d="M204.236,84.744c-20.803,0-37.727,16.924-37.727,37.726c0,20.802,16.924,37.726,37.727,37.726c20.802,0.001,37.726-16.923,37.726-37.726C241.963,101.668,225.039,84.744,204.236,84.744z M204.236,143.409c-11.545,0-20.94-9.392-20.94-20.939c0-11.545,9.394-20.939,20.94-20.939c11.545,0,20.939,9.393,20.939,20.939C225.175,134.016,215.782,143.409,204.236,143.409z"/></g></g><g><g><path d="M307.765,84.744c-20.803,0-37.727,16.924-37.727,37.726c0,20.802,16.924,37.727,37.727,37.727c20.802,0,37.726-16.924,37.726-37.726S328.567,84.744,307.765,84.744z M307.765,143.409c-11.545,0-20.94-9.393-20.94-20.939c0-11.545,9.393-20.939,20.94-20.939c11.545,0,20.939,9.393,20.939,20.939C328.703,134.016,319.31,143.409,307.765,143.409z"/></g></g><g><g><path d="M256.001,270.9c-30.317,0-54.982,24.664-54.982,54.982c0,4.636,3.757,8.394,8.394,8.394h93.176c4.637,0,8.394-3.758,8.394-8.394C310.982,295.565,286.318,270.9,256.001,270.9z M218.735,317.488c3.835-17.036,19.089-29.8,37.265-29.8c18.177,0,33.43,12.764,37.265,29.8H218.735z"/></g></g><g><g><circle cx="326.744" cy="267.215" r="8.394"/></g></g><g><g><circle cx="185.257" cy="267.215" r="8.394"/></g></g></svg>' );
	add_menu_page(
		__( 'Magic robots.txt', 'magic-robots-txt' ) . ' - ' . __( 'Settings', 'magic-robots-txt' ), // Page title.
		__( 'Magic robots.txt', 'magic-robots-txt' ) . wp_kses_post( $notificacion_globo ),
		'manage_options',                                                     // Capability.
		'magic-robots-txt',                                                   // Menu slug.
		'mrt_admin',                                                          // Function.
		'data:image/svg+xml;base64,' . $icono_base64,                         // Icon.
	);
}
add_action( 'admin_menu', 'mrt_add_admin_menu' );

/** Posible aviso en las páginas de administración. */
function mrt_admin_notices() {
	$html_mensaje                  = '';
	$html_problemas_archivo_robots = mrt_html_problemas_archivo_robots();
	if ( $html_problemas_archivo_robots ) {
		// Problemas con el archivo de robots.
		$html_mensaje .= $html_problemas_archivo_robots;
	} elseif ( ! mrt_conf_version() ) {
		// Congiguración pendiente.
		$html_mensaje .= '<p style="font-weight:bold;">⚠ ' . ucfirst( __( 'initial configuration recommended', 'magic-robots-txt' ) ) . '</p>';
		$html_mensaje .= '<p>';
		$html_mensaje .= ucfirst( __( 'settings are magically tuned as far as available to conservative values', 'magic-robots-txt' ) ) . ".\n ";
		$html_mensaje .= '<a href="';
		$html_mensaje .= esc_url( admin_url( 'admin.php?page=magic-robots-txt' ) );
		$html_mensaje .= '">';
		$html_mensaje .= ucfirst( __( 'confirm or customize them', 'magic-robots-txt' ) );
		$html_mensaje .= '</a> ';
		$html_mensaje .= __( 'for better results', 'magic-robots-txt' ) . ".<br />\n";
		$html_mensaje .= '</p>';
	}
	if ( $html_mensaje ) {
		// Formatea y muestra el mensaje.
		echo '<div class="notice notice-warning is-dismissible" style=height:auto;>';
		echo '<div style="float:left;margin-right:15px;padding:10px;">';
		echo '<h3>';
		echo wp_kses_post( mrt_logo() );
		echo ' ';
		echo esc_html( mrt_toma_nombre() );
		echo '</h3>';
		echo "</div>\n";
		echo wp_kses_post( $html_mensaje );
		echo "</div>\n";
	}
}
add_action( 'admin_notices', 'mrt_admin_notices' );

/**
 * Genera una etiqueta de imagen completa (img) para un logo.
 *
 * @param string $alturacss La altura CSS que se aplicará a la imagen, por defecto es '30px'.
 *
 * @return string Devuelve una cadena que representa una etiqueta de imagen HTML, que se usa para mostrar el logo.
 */
function mrt_logo( $alturacss = '30px' ) {
	$html  = '<img src="';
	$html .= plugin_dir_url( __DIR__ ) . 'admin/images/robot.svg';
	$html .= '" style="width:auto;height:';
	$html .= $alturacss;
	$html .= ';vertical-align:middle;" alt="Robot">';
	return $html;
}

/** Crea el contenido de la página de ajustes. */
function mrt_admin() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'No tienes suficientes permisos para acceder a esta página.' );
	}
	?>
	<div class="wrap">
		<h1 style="text-align:center;">
		<?php
		echo wp_kses_post( mrt_logo() ) . ' ';
		echo esc_html( mrt_toma_nombre() ) . ' ';
		echo '<small>v' . esc_html( mrt_get_version() ) . '</small>';
		?>
		</h1>
		<hr>

		<form method="POST" action="options.php">
			<?php
				settings_fields( 'magic-robots-txt-ajustes' );
				do_settings_sections( 'magic-robots-txt-ajustes' );
				submit_button();
			?>
		</form>
	</div>
	<hr>

	<?php
	if ( WP_DEBUG ) {
		echo '<h3>';
		esc_html_e( 'System status (Shown as debug mode is active)', 'magic-robots-txt' );
		echo '</h3>';
		mrt_echo_debug_info();
	}
}

/**
 * Maneja acciones posteriores a la actualización de opciones específicas del plugin.
 *
 * Esta función se engancha en la acción `updated_option` de WordPress y establece
 * un transitorio cuando se actualiza una opción relacionada con el plugin 'Magic robots.txt'.
 * Esto permite realizar acciones solo una vez después de que las opciones relevantes
 * han sido actualizadas, como regenerar archivos o limpiar cachés.
 *
 * @param string $option_name El nombre de la opción que se ha actualizado. Se espera que
 *                            comience con 'mrt_' para las opciones relevantes del plugin.
 */
function mrt_on_option_update( $option_name ) {
	// Comprueba si la opción actualizada es relevante para el plugin.
	if ( false !== strpos( $option_name, 'mrt_' ) ) {
		// Establece un transitorio para indicar que una opción relevante ha sido actualizada.
		// El transitorio 'mrt_settings_updated' se usa para desencadenar acciones específicas
		// del plugin que solo deben ocurrir después de la actualización de la configuración.
		set_transient( 'mrt_settings_updated', 'yes', 30 );
	}
}
// Engancha la función al hook 'updated_option' de WordPress.
add_action( 'updated_option', 'mrt_on_option_update', 10, 1 );

/** Funcionalidad de la página de ajustes. */
function mrt_settings_init() {
	// Preproceso requerido de la lista de opciones.
	foreach ( mrt_lista_opciones() as $nombre_opcion ) {
		register_setting( 'magic-robots-txt-ajustes', $nombre_opcion );
	}

	// Gestión de uso de archivo físico.
	// if ( isset( $_GET['settings-updated'] ) ) {
	// Mediante el transitorio creado en mrt_on_option_update, sabremso que se grabaron las opciones sin requerir
	// el acceso a $_GET y el consiguiente requisito de nonce de WPCS.
	if ( get_transient( 'mrt_settings_updated' ) ) {
		// Grabando ajustes es el momento de editar el archivo robots.txt físico si corresponde.
		// Solo si (está configurado hacerlo o es forzoso) y se puede.
		if ( mrt_utilizable_archivo_robots() && ( mrt_conf_usar_archivo() || mrt_usar_archivo_forzoso() ) ) {
			// Si realmente puede y debe trabajar con el archivo físico, se pone manos a la obra.
			$contenido         = '';
			$robots_txt_previo = '';
			if ( mrt_existe_archivo_robots() ) {
				// Si existe previamente lo procesa.
				$robots_txt_previo = mrt_lee_archivo_robots();
			}
			$contenido = mrt_edita_robots_txt( $robots_txt_previo );
			if ( $contenido ) {
				// Se graba si se ha creado contenido planeando que se debía y podría grabar.
				mrt_graba_archivo_robots( $contenido );
			}
		}
		delete_transient( 'mrt_settings_updated' ); // Liquida el transitorio.
	}

	add_settings_section(
		'mrt_seccion_asistente',                                    // $id (string) (Required) Slug-name to identify the section. Used in the 'id' attribute of tags.
		ucfirst( __( 'basic settings', 'magic-robots-txt' ) ),    // $title (string) (Required) Formatted title of the section. Shown as the heading for the section.
		'mrt_seccion_asistente_callback',                           // $callback (callable) (Required) Function that echos out any content at the top of the section (between heading and fields).
		'magic-robots-txt-ajustes'                                  // $page (string) (Required) The slug-name of the settings page on which to show the section. Built-in pages include 'general', 'reading', 'writing', 'discussion', 'media', etc. Create your own using add_options_page();
	);

	add_settings_field(
		'mrt_version',
		ucfirst( __( 'plugin version', 'magic-robots-txt' ) ),
		'mrt_version_callback',
		'magic-robots-txt-ajustes',
		'mrt_seccion_asistente',
		array( 'class' => 'hidden' )
	);

	add_settings_field(
		'mrt_carga',                                                // $id (string) (Required) Slug-name to identify the field. Used in the 'id' attribute of tags.
		ucfirst( __( 'server load', 'magic-robots-txt' ) ),       // $title (string) (Required) Formatted title of the field. Shown as the label for the field during output.
		'mrt_carga_callback',                                      // $callback (callable) (Required) Function that fills the field with the desired form inputs. The function should echo its output.
		'magic-robots-txt-ajustes',                                // $page (string) (Required) The slug-name of the settings page on which to show the section (general, reading, writing, ...).
		'mrt_seccion_asistente',                                   // $section (string) (Optional) The slug-name of the section of the settings page in which to show the box.
		array()                                                   // $args (array) (Optional) Extra arguments used when outputting the field.
	);

	add_settings_field(
		'mrt_ahorro',                                                // $id (string) (Required) Slug-name to identify the field. Used in the 'id' attribute of tags.
		ucfirst( __( 'savings', 'magic-robots-txt' ) ),            // $title (string) (Required) Formatted title of the field. Shown as the label for the field during output.
		'mrt_ahorro_callback',                                      // $callback (callable) (Required) Function that fills the field with the desired form inputs. The function should echo its output.
		'magic-robots-txt-ajustes',                                // $page (string) (Required) The slug-name of the settings page on which to show the section (general, reading, writing, ...).
		'mrt_seccion_asistente',                                     // $section (string) (Optional) The slug-name of the section of the settings page in which to show the box.
		array()                                                   // $args (array) (Optional) Extra arguments used when outputting the field.
	);

	add_settings_field(
		'mrt_sitio_publico',                                                // $id (string) (Required) Slug-name to identify the field. Used in the 'id' attribute of tags.
		ucfirst( __( 'public site', 'magic-robots-txt' ) ),            // $title (string) (Required) Formatted title of the field. Shown as the label for the field during output.
		'mrt_sitio_publico_callback',                                      // $callback (callable) (Required) Function that fills the field with the desired form inputs. The function should echo its output.
		'magic-robots-txt-ajustes',                                // $page (string) (Required) The slug-name of the settings page on which to show the section (general, reading, writing, ...).
		'mrt_seccion_asistente',                                     // $section (string) (Optional) The slug-name of the section of the settings page in which to show the box.
		array()                                                   // $args (array) (Optional) Extra arguments used when outputting the field.
	);

	add_settings_field(
		'mrt_venta_publicidad',                                                // $id (string) (Required) Slug-name to identify the field. Used in the 'id' attribute of tags.
		ucfirst( __( 'ads selling', 'magic-robots-txt' ) ),            // $title (string) (Required) Formatted title of the field. Shown as the label for the field during output.
		'mrt_venta_publicidad_callback',                                      // $callback (callable) (Required) Function that fills the field with the desired form inputs. The function should echo its output.
		'magic-robots-txt-ajustes',                                // $page (string) (Required) The slug-name of the settings page on which to show the section (general, reading, writing, ...).
		'mrt_seccion_asistente',                                     // $section (string) (Optional) The slug-name of the section of the settings page in which to show the box.
		array()                                                   // $args (array) (Optional) Extra arguments used when outputting the field.
	);

	add_settings_field(
		'mrt_venta_enlaces',                                                // $id (string) (Required) Slug-name to identify the field. Used in the 'id' attribute of tags.
		ucfirst( __( 'links selling', 'magic-robots-txt' ) ),            // $title (string) (Required) Formatted title of the field. Shown as the label for the field during output.
		'mrt_venta_enlaces_callback',                                      // $callback (callable) (Required) Function that fills the field with the desired form inputs. The function should echo its output.
		'magic-robots-txt-ajustes',                                // $page (string) (Required) The slug-name of the settings page on which to show the section (general, reading, writing, ...).
		'mrt_seccion_asistente',                                     // $section (string) (Optional) The slug-name of the section of the settings page in which to show the box.
		array()                                                   // $args (array) (Optional) Extra arguments used when outputting the field.
	);

	add_settings_field(
		'mrt_usar_archivo',                                                // $id (string) (Required) Slug-name to identify the field. Used in the 'id' attribute of tags.
		ucfirst( __( 'real or virtual file', 'magic-robots-txt' ) ),            // $title (string) (Required) Formatted title of the field. Shown as the label for the field during output.
		'mrt_usar_archivo_callback',                                      // $callback (callable) (Required) Function that fills the field with the desired form inputs. The function should echo its output.
		'magic-robots-txt-ajustes',                                // $page (string) (Required) The slug-name of the settings page on which to show the section (general, reading, writing, ...).
		'mrt_seccion_asistente',                                     // $section (string) (Optional) The slug-name of the section of the settings page in which to show the box.
		array()                                                   // $args (array) (Optional) Extra arguments used when outputting the field.
	);

	add_settings_field(
		'mrt_avanzado',                                                // $id (string) (Required) Slug-name to identify the field. Used in the 'id' attribute of tags.
		ucfirst( __( 'advanced settings', 'magic-robots-txt' ) ),            // $title (string) (Required) Formatted title of the field. Shown as the label for the field during output.
		'mrt_avanzado_callback',                                      // $callback (callable) (Required) Function that fills the field with the desired form inputs. The function should echo its output.
		'magic-robots-txt-ajustes',                                // $page (string) (Required) The slug-name of the settings page on which to show the section (general, reading, writing, ...).
		'mrt_seccion_asistente',                                     // $section (string) (Optional) The slug-name of the section of the settings page in which to show the box.
		array()                                                   // $args (array) (Optional) Extra arguments used when outputting the field.
	);
}
add_action( 'admin_init', 'mrt_settings_init' );

// Callbacks para la presentación de datos de opciones.

/** Genera la descripción de la sección de configuración general en el panel de control del plugin.
 *
 * @return void
 */
function mrt_seccion_general_callback() {
	echo esc_html( ucfirst( __( 'general settings section', 'magic-robots-txt' ) ) );
	echo ".\n";
}

/** Genera las instrucciones para cambiar la configuración en el asistente del panel de control del plugin.
 *
 * @return void
 */
function mrt_seccion_asistente_callback() {
	echo esc_html( ucfirst( __( 'change the settings you are sure they are different to the current selected values', 'magic-robots-txt' ) ) );
	echo ".<br />\n";
	echo esc_html( ucfirst( __( 'click save changes once you are done and rely on magic for the best settings for you', 'magic-robots-txt' ) ) );
	echo ".<br />\n";
}

/** Campo oculto indicando con qué versión se grabó la configuración. */
function mrt_version_callback() {
	echo '<input name="mrt_version" type="hidden" id="mrt_version" value="';
	echo esc_attr( mrt_get_version() );
	echo '" />';
}

/** Crea la interfaz de selección para la opción de carga del servidor en el panel de control del plugin.
 *
 * @return void
 */
function mrt_carga_callback() {
	if ( mrt_conf_carga() ) {
		$nivel_carga = mrt_conf_carga();
	} elseif ( mrt_carga_calculable() ) {
		// Considera el nivel obtenido si es posible.
		echo esc_html( ucfirst( __( 'the server load detected is', 'magic-robots-txt' ) ) . ' ' );
		$carga       = mrt_carga_15();
		$nivel_carga = mrt_nivel_carga( $carga );
		echo esc_html( ucfirst( mrt_texto_carga( $nivel_carga ) ) );
		echo ".<br />\n";
		// Considera el nivel por omisión si no es posible obtenerlo.
	} else {
		$carga       = mrt_carga_omision();
		$nivel_carga = mrt_nivel_carga( $carga );
		echo esc_html( ucfirst( __( 'server load can\'t be detected', 'magic-robots-txt' ) ) . '. ' );
		/* translators: %s: Load average number. */
		echo esc_html( ucfirst( sprintf( __( 'don\'t worry, estimating a %s value', 'magic-robots-txt' ), mrt_texto_carga( $nivel_carga ) ) ) . ' ' );
		esc_html_e( 'does the trick', 'magic-robots-txt' );
		echo ".<br /><br />\n";
	}
	echo '<input type="radio" name="mrt_carga" value="4" ' . checked( '4', $nivel_carga, false ) . '>';
	echo esc_html( ucfirst( __( 'overloaded', 'magic-robots-txt' ) ) );
	echo '. <span style="opacity:0.6">';
	echo esc_html( ucfirst( __( 'the server is frequently overloaded or slow responsive', 'magic-robots-txt' ) ) );
	echo '.</span><br />';
	echo '<input type="radio" name="mrt_carga" value="3" ' . checked( '3', $nivel_carga, false ) . '>';
	echo esc_html( ucfirst( __( 'loaded', 'magic-robots-txt' ) ) );
	echo '. <span style="opacity:0.6">';
	echo esc_html( ucfirst( __( 'sometimes the server is slow (default)', 'magic-robots-txt' ) ) );
	echo '.</span><br />';
	echo '<input type="radio" name="mrt_carga" value="2" ' . checked( '2', $nivel_carga, false ) . '>';
	echo esc_html( ucfirst( __( 'normal', 'magic-robots-txt' ) ) );
	echo '. <span style="opacity:0.6">';
	echo esc_html( ucfirst( __( 'all is fine', 'magic-robots-txt' ) ) );
	echo '.</span><br />';
	echo '<input type="radio" name="mrt_carga" value="1" ' . checked( '1', $nivel_carga, false ) . '>';
	echo esc_html( ucfirst( __( 'bored', 'magic-robots-txt' ) ) );
	echo '. <span style="opacity:0.6">';
	echo esc_html( ucfirst( __( 'the server has almost no job to do', 'magic-robots-txt' ) ) );
	echo '.</span><br />';
}

/** Crea la interfaz de selección para la opción de ahorro de recursos en el panel de control del plugin.
 *
 * @return void
 */
function mrt_ahorro_callback() {
	echo esc_html( ucfirst( __( 'reducing unneeded accesses and crawling speeds saves server resources, making the site faster', 'magic-robots-txt' ) ) );
	echo '. ';
	echo esc_html( ucfirst( __( 'too much saving may have a little cons or delays in search engines ot others', 'magic-robots-txt' ) ) );
	echo ".<br /><br />\n";
	echo '<input type="radio" name="mrt_ahorro" value="4" ' . checked( '4', mrt_conf_ahorro(), false ) . '>';
	echo esc_html( ucfirst( __( 'high', 'magic-robots-txt' ) ) );
	echo '<br />';
	echo '<input type="radio" name="mrt_ahorro" value="3" ' . checked( '3', mrt_conf_ahorro(), false ) . '>';
	echo esc_html( ucfirst( __( 'balanced', 'magic-robots-txt' ) ) );
	echo ' <span style="opacity:0.6">(';
	esc_html_e( 'recommended', 'magic-robots-txt' );
	echo ')</span><br />';
	echo '<input type="radio" name="mrt_ahorro" value="2" ' . checked( '2', mrt_conf_ahorro(), false ) . '>';
	echo esc_html( ucfirst( __( 'low', 'magic-robots-txt' ) ) );
	echo '<br />';
	echo '<input type="radio" name="mrt_ahorro" value="1" ' . checked( '1', mrt_conf_ahorro(), false ) . '>';
	echo esc_html( ucfirst( __( 'none', 'magic-robots-txt' ) ) );
	echo '<br />';
}

/** Crea la interfaz de selección para la opción de accesibilidad pública del sitio en el panel de control del plugin.
 *
 * @return void
 */
function mrt_sitio_publico_callback() {
	$sitio_publico = get_option( 'blog_public' );
	echo '<span title="';
	echo esc_attr( ucfirst( __( 'automatic detected', 'magic-robots-txt' ) ) );
	echo '">';
	mrt_muestra_tick( $sitio_publico );
	echo ' ';
	echo esc_html( ucfirst( __( 'publicly accesable site', 'magic-robots-txt' ) ) );
	echo '.';
	echo '</span>';
	echo '<p class="description" id="tagline-description">';
	echo esc_html( ucfirst( __( 'checked if this site is available to general public visitors', 'magic-robots-txt' ) ) );
	echo '. ';
	echo esc_html( ucfirst( __( 'unchecked if closed access to search engines', 'magic-robots-txt' ) ) );
	echo '.<br />';
	if ( $sitio_publico ) {
		echo esc_html( ucfirst( __( 'detected the site is public', 'magic-robots-txt' ) ) );
		echo ', ';
		echo esc_html( ucfirst( __( 'this is recommended for 99 % of sites', 'magic-robots-txt' ) ) );
		echo '.<br />';
	} else {
		echo esc_html( ucfirst( __( 'detected the site is not public', 'magic-robots-txt' ) ) );
		echo '. ';
		echo esc_html( ucfirst( __( 'this is an uncommon status, be sure or things will go really wrong with search engines', 'magic-robots-txt' ) ) );
		echo '.<br />';
	}
	echo esc_html( ucfirst( __( 'verify', 'magic-robots-txt' ) ) );
	echo ' ';
	echo '<a href="';
	echo esc_url( admin_url( 'options-reading.php' ) );
	echo '" target="_blank">';
	esc_html_e( 'Settings', 'magic-robots-txt' );
	echo ' &gt; ';
	esc_html_e( 'Reading', 'magic-robots-txt' );
	echo ' &gt; ';
	esc_html_e( 'Search engine visibility', 'magic-robots-txt' );
	echo '</a> ';
	esc_html_e( 'if this is wrong', 'magic-robots-txt' );
	echo ".</p>\n";
}

/** Crea la interfaz de selección para la opción de venta de publicidad en el panel de control del plugin.
 *
 * @return void
 */
function mrt_venta_publicidad_callback() {
	$hay_plugin_publi = mrt_hay_plugin_publi();
	// *** Tal vez si se detecta el plugin pero se marcó que no, conviene respetarlo... ***
	if ( $hay_plugin_publi ) {
		echo '<span title="';
		echo esc_attr( ucfirst( __( 'automatic detected', 'magic-robots-txt' ) ) );
		echo '">';
		mrt_muestra_tick( $hay_plugin_publi );
		echo ' ';
		echo '<input type="hidden" name="mrt_venta_publicidad" value="1">';
		echo esc_html( ucfirst( __( 'selling ads space', 'magic-robots-txt' ) ) );
		echo '.';
		echo '</span><br />';
		/* translators: %s: plugin name */
		echo esc_html( ucfirst( sprintf( __( 'checked as <b>%s</b> plugin identified as advertising related', 'magic-robots-txt' ), mrt_nombre_plugin_publi() ) ) );
		echo '.';
		echo '</span><br />';
		echo '<p class="description" id="tagline-description">';
		echo esc_html( ucfirst( __( 'open a support ticket if this is wrong', 'magic-robots-txt' ) ) );
		echo '.</p>';
	} else {
		echo '<input type="checkbox" name="mrt_venta_publicidad" ';
		echo 'value="1" ';
		checked( mrt_conf_venta_publicidad(), 1 );
		echo '> ';
		echo esc_html( ucfirst( __( 'selling ads space', 'magic-robots-txt' ) ) );
		echo '.';
		echo '<p class="description" id="tagline-description">';
		echo esc_html( ucfirst( __( 'uncheck if you don\'t have dynamic external ads, i.e. AdSense', 'magic-robots-txt' ) ) );
		echo '.</p>';
	}
}

/** Crea la interfaz de selección para la opción de venta de enlaces en el panel de control del plugin.
 *
 * @return void
 */
function mrt_venta_enlaces_callback() {
	echo '<input type="checkbox" name="mrt_venta_enlaces" ';
	echo 'value="1" ';
	checked( mrt_conf_venta_enlaces(), 1 );
	echo '> ';
	echo esc_html( ucfirst( __( 'exchanging links', 'magic-robots-txt' ) ) );
	echo '.';
	echo '<p class="description" id="tagline-description">';
	echo esc_html( ucfirst( __( 'uncheck if you are not interested in being located to exchanging or selling links or guest posts', 'magic-robots-txt' ) ) );
	echo '.</p>';
}

/** Crea la interfaz de selección para la opción de usar un archivo en el panel de control del plugin.
 *  Determina si se debe usar un archivo real para la configuración del robots.txt o si se puede utilizar una configuración virtual.
 *
 * @return void
 */
function mrt_usar_archivo_callback() {
	$mrt_usar_archivo_forzoso = mrt_usar_archivo_forzoso();
	$usar_archivo_omision     = mrt_usar_archivo_omision();
	if ( $mrt_usar_archivo_forzoso ) {
		// Si es forzoso usar el archivo, mejor grabarlo como elección.
		echo '<span title="';
		echo esc_html( ucfirst( __( 'automatic detected', 'magic-robots-txt' ) ) );
		echo '">';
		mrt_muestra_tick( $usar_archivo_omision );
		echo ' ';
		echo '<input type="hidden" name="mrt_usar_archivo" value="1">';
		echo esc_html( ucfirst( __( 'use real file', 'magic-robots-txt' ) ) );
		echo '.';
		echo '</span><br />';
	} else {
		// Cuando hay libertad, elegir.
		echo '<input type="checkbox" name="mrt_usar_archivo" ';
		echo 'value="1" ';
		checked( mrt_conf_usar_archivo(), 1 );
		echo '> ';
		echo esc_html( ucfirst( __( 'use real file', 'magic-robots-txt' ) ) );
		echo '.';
	}
	if ( $mrt_usar_archivo_forzoso ) {
		echo '<p class="description" id="tagline-description">';
		echo esc_html( ucfirst( __( 'is mandatory to use a real robots.txt file due to subdirectory installation of WordPress', 'magic-robots-txt' ) ) );
		echo '.</p>';
	} elseif ( mrt_usar_archivo_omision() ) {
		echo '<p class="description" id="tagline-description">';
		echo esc_html( ucfirst( __( 'robots are using the existent real robots.txt file located at', 'magic-robots-txt' ) ) );
		echo ' ';
		echo esc_html( mrt_ruta_archivo_robots() );
		echo '.<br />';
		echo esc_html( ucfirst( __( 'unchecking this to use a virtual robots.txt file will work after you managed to backup and delete the real file', 'magic-robots-txt' ) ) );
		echo '.</p>';
	} else {
		echo '<p class="description" id="tagline-description">';
		echo esc_html( ucfirst( __( 'check for a real robots.txt file', 'magic-robots-txt' ) ) );
		echo '.<br />';
		echo esc_html( ucfirst( __( 'uncheck for a virtual robots.txt file', 'magic-robots-txt' ) ) );
		echo '.</p>';
	}
	// Ya se han mostrado en la cabecera como aviso administrativo los mrt_html_problemas_archivo_robots().
}

/** Crea la interfaz de selección para la opción de configuración avanzada en el panel de control del plugin.
 *
 * @return void
 */
function mrt_avanzado_callback() {
	echo "<input type='checkbox' name='mrt_avanzado' ";
	checked( mrt_conf_avanzado(), 1 );
	echo " value='1'> ";
	echo esc_html( ucfirst( __( 'show', 'magic-robots-txt' ) ) );
	echo ' ';
	echo esc_html( __( 'advanced settings', 'magic-robots-txt' ) );
	echo '.';
	echo '<p class="description" id="tagline-description">';
	echo esc_html( ucfirst( __( 'check if you\'d like to use the advanced settings mode', 'magic-robots-txt' ) ) );
	echo '. ';
	echo esc_html( ucfirst( __( 'can be undone at any moment if you are uncomfortable with the advanced settings', 'magic-robots-txt' ) ) );
	echo '.</p>';
	echo '<span style="font-weight:bold">';
	echo esc_html( ucfirst( __( 'not available yet', 'magic-robots-txt' ) ) );
	echo '.</span></p>';
}

/** Muestra '✔' si el valor es verdadero; de lo contrario, muestra '❌'.
 *
 * @param mixed $booleano El valor a verificar. Aunque puede ser cualquier tipo, forzará a un valor booleano.
 *
 * @return void
 */
function mrt_muestra_tick( $booleano ) {
	if ( $booleano ) {
		echo '✔';
	} else {
		echo '❌';
	}
}

/** Genera el texto correspondiente a un nivel de carga dado, directamente traducido.
 *
 * @param int $nivel El nivel de carga del sistema.
 *
 * @return string El texto correspondiente al nivel de carga.
 */
function mrt_texto_carga( $nivel ) {
	// Genera el texto correspondiente a un nivel de carga dado, directamente traducido.
	switch ( $nivel ) {
		case 4:
			$texto = __( 'overloaded', 'magic-robots-txt' );
			break;
		case 3:
			$texto = __( 'loaded', 'magic-robots-txt' );
			break;
		case 2:
			$texto = __( 'normal', 'magic-robots-txt' );
			break;
		case 1:
			$texto = __( 'bored', 'magic-robots-txt' );
			break;
		default:
			// Condición de error. Tipo de actualización imprevisto.
			$texto = __( 'error', 'magic-robots-txt' );
	}
	return $texto;
}

/** Genera el nivel de carga numérico correspondiente a una carga promedio dada.
 * No se considera el nivel aburrido (1) por ahora.
 *
 * @param float $carga La carga promedio del sistema.
 *
 * @return int El nivel de carga numérico.
 */
function mrt_nivel_carga( $carga ) {
	// Genera el nivel de carga numérico correspondiente a una carga promedio dada.
	if ( mrt_saturado( $carga ) ) {
		$nivel = 4;
	} elseif ( mrt_cargado( $carga ) ) {
		$nivel = 3;
	} else {
		$nivel = 2;
	}
	return $nivel;
}

/** Determina si la carga promedio del sistema indica que el servidor está cargado.
 *
 * @param float $carga La carga promedio del sistema.
 *
 * @return bool Verdadero si el servidor está cargado, falso en caso contrario.
 */
function mrt_cargado( $carga ) {
	// Si la carga promedio alcanza 0.6 sin llegar a 1.5, considera el servidor cargado.
	// La comparación devolverá un booleano directamente.
	return $carga >= 0.6 && $carga < 1.5;
}

/** Determina si la carga promedio del sistema indica que el servidor está saturado.
 *
 * @param float $carga La carga promedio del sistema.
 *
 * @return bool Verdadero si el servidor está saturado, falso en caso contrario.
 */
function mrt_saturado( $carga ) {
	// Si la carga promedio supera 1.5, considera el servidor saturado.
	// La comparación devolverá un booleano directamente.
	return $carga >= 1.5;
}

/** Devuelve la carga promedio de los últimos 15 minutos.
 *  No funciona en Windows, pero se proporciona una alternativa en los comentarios.
 *
 * @return float La carga promedio de los últimos 15 minutos, o una carga media si no se puede obtener.
 */
function mrt_carga_15() {
	// Devuelve la carga promedio de los últimos 15 minutos.
	// No opera en Windows, en los comentarios de https://www.php.net/manual/en/function.sys-getloadavg.php hay una alternativa.
	if ( stristr( PHP_OS, 'win' ) ) {
		// Sin obtenerla, en Windows considera una carga media.
		$carga_15 = mrt_carga_omision();
	} else {
		$carga = sys_getloadavg();
		if ( $carga ) {
			$carga_15 = $carga[2];
		} else {
			$carga_15 = mrt_carga_omision();
		}
	}
	return $carga_15;
}

/**
 * Determina si se puede obtener la carga del sistema.
 *
 * @return bool Verdadero si es calculable, falso si no se puede obtener.
 */
function mrt_carga_calculable() {
	$carga = sys_getloadavg();

	// Verificamos si la carga es un array y no está vacío.
	// sys_getloadavg() devuelve un array con los promedios de carga o un array vacío si no se puede obtener.
	$calculable = is_array( $carga ) && ! empty( $carga );

	return $calculable;
}

/** Devuelve un valor numérico con el load average a considerar por omisión.
 *
 * @return float Nivel de carga considerado,
 */
function mrt_carga_omision() {
	// Si no se puede obtener, considera esta carga (load average).
	$carga_omision = 1.00;
	return $carga_omision;
}

/** Muestra diversos datos de depuración. */
function mrt_echo_debug_info() {
	// Toma datos sobre un posible archivo físico.
	if ( mrt_ruta_archivo_robots() ) {
		echo '<h4>';
		echo esc_html( ucfirst( __( 'physical file robots.txt availability', 'magic-robots-txt' ) ) );
		echo '</h4>';

		echo esc_html( ucfirst( __( 'path', 'magic-robots-txt' ) ) );
		echo ': <b>';
		echo esc_html( mrt_ruta_archivo_robots() );
		echo '</b><br /> ';

		mrt_muestra_tick( mrt_existe_archivo_robots() );
		echo ' ';
		echo esc_html( ucfirst( __( 'exists', 'magic-robots-txt' ) ) );
		echo "<br />\n";

		mrt_muestra_tick( mrt_legible_archivo_robots() );
		echo ' ';
		echo esc_html( ucfirst( __( 'readable', 'magic-robots-txt' ) ) );
		echo "<br />\n";

		mrt_muestra_tick( mrt_escribible_archivo_robots() );
		echo ' ';
		echo esc_html( ucfirst( __( 'writable', 'magic-robots-txt' ) ) );
		echo "<br />\n";

		mrt_muestra_tick( mrt_escribible_directorio_robots() );
		echo ' ';
		echo esc_html( ucfirst( __( 'writable directory', 'magic-robots-txt' ) ) );
		echo "<br />\n";
	}

	// Indica, si es posible obtenerla, la carga del servidor.
	echo '<h4>';
	echo esc_html( ucfirst( __( 'server load', 'magic-robots-txt' ) ) );
	echo '</h4>';

	if ( mrt_carga_calculable() ) {
		echo esc_html( ucfirst( __( 'load', 'magic-robots-txt' ) ) );
		echo ': <b>';
		echo esc_html( mrt_carga_15() );
		echo '</b><br />';
	} else {
		echo esc_html( ucfirst( __( 'can\'t determine server load', 'magic-robots-txt' ) ) );
		echo '.<br />';
	}

	// Estado sitemaps.
	echo '<h4>';
	echo esc_html( ucfirst( __( 'sitemaps', 'magic-robots-txt' ) ) );
	echo '</h4>';

	// Sitemap configurado en Yoast.Devuelve 1 si está activo.
	mrt_muestra_tick( mrt_sitemaps_enabled() );
	echo ' ';
	echo esc_html( ucfirst( __( 'sitemaps enabled', 'magic-robots-txt' ) ) );
	echo '<br />';
	// Sitemap configurado en Yoast.Devuelve 1 si está activo.
	$yoast_options = get_option( 'wpseo' );
	if ( $yoast_options ) {
		$yoast_sitemap = $yoast_options['enable_xml_sitemap'];
		mrt_muestra_tick( $yoast_sitemap );
		echo ' ';
		echo esc_html( ucfirst( __( 'Yoast SEO sitemap', 'magic-robots-txt' ) ) );
		echo '<br />';
	}

	// Link al actual robots.txt.
	echo '<h4>';
	echo esc_html( ucfirst( __( 'current', 'magic-robots-txt' ) ) );
	echo ' robots.txt</h4>';

	echo '<a href="/robots.txt" target="_blank">';
	/* translators: %s: 'robots.txt' filename */
	echo esc_html( ucfirst( sprintf( __( 'see the current %s content', 'magic-robots-txt' ), 'robots.txt' ) ) );
	echo '</a><br />';

	echo 'mrt_subdirectorio_wp: ';
	echo esc_html( mrt_subdirectorio_wp() );
	echo '<br />';
}

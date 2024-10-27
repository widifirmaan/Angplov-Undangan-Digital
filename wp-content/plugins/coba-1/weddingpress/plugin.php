<?php

/**
 * Check if Elementor is installed
 *
 * @since 1.0
 *
 */
if ( ! function_exists( '_is_elementor_installed' ) ) {
    function _is_elementor_installed() {
        $file_path = 'elementor/elementor.php';
        $installed_plugins = get_plugins();
        return isset( $installed_plugins[ $file_path ] );
    }
}

/**
 * Shows notice to user if Elementor plugin
 * is not installed or activated or both
 *
 * @since 1.0
 *
 */

function wdp_fail_load() {
    $plugin = 'elementor/elementor.php';

    if ( _is_elementor_installed() ) {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
        $message = __( 'WeddingPress mewajibkan mengaktifkan Elementor plugin. Silahkan aktifkan sekarang.', 'wdp' );
        $button_text = __( 'Klik Aktivasi Elementor', 'wdp' );

    } else {
        if ( ! current_user_can( 'install_plugins' ) ) {
            return;
        }

        $activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
        $message = sprintf( __( 'WeddingPress mewajibkan menggunakan "Elementor" lakukan install dan aktivasi. Silahkan install elementor.', 'wdp' ), '<strong>', '</strong>' );
        $button_text = __( 'Install Elementor', 'wdp' );
    }

    $button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';
    
    printf( '<div class="error"><p>%1$s</p>%2$s</div>', esc_html( $message ), $button );
}



/**
 * The admin area, activate and deactivate license, system website information source code from.
 * Credit to   Agus Muhammad
 * @link       https://agusmu.com
 * @link       https://landingpress.net
 * @link       https://landingkit.co
 * @link       https://wpbisnis.com
 *
 */



class WeddingPressV3_Plugin {

	public function __construct() {
		
		if ( is_admin() ) {
		add_action( 'admin_menu', array( $this, 'create_settings' ), 99 );
		add_action( 'admin_init', array( $this, 'setup_sections' ) );
		add_action( 'admin_init', array( $this, 'setup_fields' ) );
		}
		add_action( 'added_option', array( $this, 'added_license' ), 10, 2 );
		add_action( 'updated_option', array( $this, 'updated_license' ), 10, 3 );
		add_action( 'admin_notices', array( $this, 'show_invalid_license_notice' ) );
		add_action( 'wp_ajax_guestbook_box_submit', [$this, 'guestbook_box_submit'] );
		add_action( 'wp_ajax_nopriv_guestbook_box_submit', [$this, 'guestbook_box_submit'] );
		
		
	}


	public function is_active() {
		if ( WEDDINGPRESS_ELEMENTOR_PLUGIN ) {
			$license_status = get_option( 'weddingpress_license_status' );
			if ( ! ( isset( $license_status->license ) && $license_status->license == 'valid' ) )
				return false;
		}
		else {
			$license_status = get_option( get_template().'_license_key_status' );
			if ( $license_status != 'valid' )
				return false;
		}
		return true;
	}
	
	public function create_settings() {
		add_menu_page(
            'WeddingPress',
            'WeddingPress',
            'manage_options',
            'weddingpress',
            array( $this, 'settings_content' ),
            plugins_url( 'weddingpress/assets/img/icon.png' ),
            '3'
        );

	}

	public function settings_content() {
		echo '<div class="wrap">'; 
		echo '<h2>'.esc_html__( 'WeddingPress', 'weddingpress' ).'</h2>';
		echo '<div class="wdp-elementor-form" style="max-width: 630px; background: #fff; margin: 20px 0; padding: 20px;">';
		echo '<form method="POST" action="options.php">';
			settings_fields( 'wdp_elementor' );
			do_settings_sections( 'wdp_elementor' );
			submit_button();
		echo '</form>';
		echo '</div>';
		echo '</div>';
	}

	public function setup_sections() {
		add_settings_section( 'weddingpress_elementor_license', esc_html__( 'Activate License', 'weddingpress' ), array(), 'wdp_elementor' );
		if ( $this->is_active() ) {
			add_settings_section( 'weddingpress_elementor_status', esc_html__( 'Setting', 'weddingpress' ), array(), 'wdp_elementor' );
		}	
	}

	
	public function license_field() {
		$license = trim( get_option( 'weddingpress_license' ) );
		$this->check_license();
		$license_status = get_option( 'weddingpress_license_status' );
		?>
		<?php if ( isset( $license_status->license ) && ( $license_status->license == 'valid' || $license_status->license == 'expired' || $license_status->license == 'no_activations_left' || $license_status->license == 'inactive' ) ) : ?>
			<?php 
			$expires = '';
			if ( isset( $license_status->expires ) && 'lifetime' != $license_status->expires ) {
				$expires = ', hingga '.date_i18n( get_option( 'date_format' ), strtotime( $license_status->expires, current_time( 'timestamp' ) ) );
			} 
			elseif ( isset( $license_status->expires ) && 'lifetime' == $license_status->expires ) {
				$expires = ', Lisensi Lifetime';
			}
			$site_count = $license_status->site_count;
			$license_limit = $license_status->license_limit;
			if ( 0 == $license_limit ) {
				$license_limit = ', unlimited';
			}
			elseif ( $license_limit > 1 ) {
				$license_limit = ', Anda sudah mengaktifkan lisensi ini untuk '.$site_count.' website dari limit '.$license_limit.' website yang tersedia.';
			}
			if ( $license_status->license == 'expired' ) {
				$renew_link = '<br/><a href="https://weddingpress.co.id/renewal/" target="_blank">klik di sini untuk perpanjang lisensi</a>';
			}

			?>
			<style>
				.wdp-elementor-form {
				 max-width: 630px;
    				background: #fff;
    				margin: 20px 0;
    				padding: 20px; }
				.wdp-elementor-form h3 {
				 	max-width: 630px;
    				background: #fff;
    				margin: 20px 0;
					border-bottom: 1px solid #eee;
    				padding: 20px;
    				margin: -20px -20px 20px;
    				padding: 20px; }
				.wdp-elementor-yes{ background: none; color: #008000; } 
				.wdp-elementor-error{ background: none; color: #ff0000; }
				.wdp-elementor {
    				font-size: 13px;
    				font-style: normal; }
				 span.description{ display: block; }
				.wdp-elementor-form h2 {border-bottom: 1px solid #eee; padding: 20px;margin: -20px -20px 20px;}
				h2, h3 {color: #23282d;font-size: 1.5em;margin: 1em 0;border-bottom: 1px solid #eee;padding: 20px;margin: -20px -20px 20px;}
			</style>
			<input name="weddingpress_license" type="hidden" value="<?php echo $license; ?>">
			<input name="weddingpress_license_hidden" id="weddingpress_license_hidden" type="text" style="min-width:280px;" value="<?php echo $this->get_hidden_license( $license ); ?>" class="" placeholder="" disabled> <input name="wdp_elementor_deactivate" class="button button-secondary" type="submit" value="Deactivate">
			<?php if ( $license_status->license == 'valid' ) : ?>
				<span class="description wdp-elementor-yes">
					<br/>
					<?php echo '<strong>Status:</strong> ✓&nbsp;Kode lisensi&nbsp;'.$license_status->license.$expires; ?>
				</span>
				<p class="wdp-elementor-active"><br><a class="button button-primary" href="https://garudanesia.com/member-area/" target="_blank">My Account</a> &nbsp; <a class="button button-secondary" href="https://membershipdigital.com/support" target="_blank">Support</a> &nbsp; <a class="button button-secondary" href="https://membershipdigital.com/support/video-tutorial" target="_blank">Tutorial</a>
			<?php elseif ( $license_status->license == 'expired' ) : ?>
				<span class="description wdp-elementor-error">
					<br/>
					<?php echo '<strong>'.$license_status->license.'</strong>'.$expires.$license_limit; ?>
				</span>
				<?php echo $renew_link; ?>
			<?php elseif ( $license_status->license == 'no_activations_left' ) : ?>
				<span class="description wdp-elementor-error">
					<br/>
					<?php echo '<strong>lisensi habis</strong>'.$license_limit; ?>
				</span>
			<?php endif; ?>
			
		<?php else : ?>
			<input name="weddingpress_license" id="weddingpress_license" type="text" style="max-width:280px;" value="<?php echo $license; ?>" class="regular-text code" placeholder="masukkan kode licensi di sini"> <input name="wdp_elementor_activate" class="button button-primary" type="submit" value="Activate">
			<span class="description">
				<?php if ( $license && isset( $license_status->license ) ) : ?>
					<br/>
					<span class="wdp-elementor-error">
						Status: <?php echo '<strong>'.$license_status->license.'</strong>'; ?>
					</span>
				<?php endif; ?>
			</span>	
				<br/><br/>
				 <span class="wdp-elementor">Kode lisensi WeddingPress yang aktif dibutuhkan untuk mendapatkan update, support, dan akses template library.</span>
				<h4 class="wdp-elementor">Cara Mendapatkan Kode Lisensi?</h4>
				<p class="wdp-elementor">
					<ol>
						<li>
						<a href="https://garudanesia.com/member-area" target="_blank">Login ke member area</a>, jika Anda SUDAH pernah membeli WeddingPress.
						</li>
						<li>
							<a href="https://weddingpress.net" target="_blank">Beli WeddingPress</a>, Jika Anda BELUM pernah membeli WeddingPress.
						</li>
						<li>
							Copy kode licensi, kemudian paste di kolom licensi, klik Activate.
						</li>
					</ol>
				<p/>
		<?php endif; ?>
		<?php 
	}
	
	/**
	 * Checks if license is valid and gets expire date.
	 *
	 * @since 1.0.0
	 *
	 * @return string $message License status message.
	 */
	public function check_license() {
		global $wp_version;
		$license = trim( get_option( 'weddingpress_license' ) );
		$api_params = array(
			'edd_action' => 'check_license',
			'license' => $license,
			'item_name' => urlencode( WEDDINGPRESS_ELEMENTOR_NAME ),
			'url'	   => home_url()
		);
		if(!empty($license)) {
		$response = json_encode(array(
		    "success"=>true,
		    "license"=>"valid",
		    "item_id"=>false,
		    "item_name"=>$this->item_name,
		    "error"=>"",
		    "license_limit"=>0,
		    "site_count"=>'9999',
		    "expires"=>"lifetime",
		    "activations_left"=>"unlimited",
		    "customer_name"=>'weddingpress',
		    "customer_email"=>'nulled@weddingpress.id',
	    ));
		$license_data = json_decode($response);
		if( $license_data->license == 'inactive' || $license_data->license == 'site_inactive' ) {
			if ( $license_data->activations_left === 0 ) {
				$license_data->license = 'no_activations_left';
			}
			else {
				$this->activate_license();
			}
		} 
		update_option( 'weddingpress_license_status', $license_data );
		}
	}

	/**
	 * Activates the license key.
	 *
	 * @since 1.0.0
	 */
	public function activate_license() {
		$license = trim( get_option( 'weddingpress_license' ) );
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'	=> $license,
			'item_name'  => urlencode( WEDDINGPRESS_ELEMENTOR_NAME ), 
			'url'		=> home_url()
		);
		$response = wp_remote_post( WEDDINGPRESS_ELEMENTOR_STORE, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		if ( is_wp_error( $response ) ) {
		    $error_string = $response->get_error_message();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
		}
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		if ( false !== $license_data->success ) {
			$this->check_license();
		}
	}
	
	/**
	 * Deactivates the license key.
	 *
	 * @since 1.0.0
	 */
	public function deactivate_license() {
		$license = trim( get_option( 'weddingpress_license' ) );
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'	=> $license,
			'item_name'  => urlencode( WEDDINGPRESS_ELEMENTOR_NAME ),
			'url'		=> home_url()
		);
		$response = wp_remote_post( WEDDINGPRESS_ELEMENTOR_STORE, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		if ( is_wp_error( $response ) ) {
		    $error_string = $response->get_error_message();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
		}
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		if( $license_data->license == 'deactivated' ) {
			delete_option( 'weddingpress_license_status' );
		}
	}

	public function added_license( $option_name, $option_value ) {
		if ( isset( $_POST['wdp_elementor_activate'] ) ) {
			$this->activate_license();
		}
		if ( isset( $_POST['wdp_elementor_deactivate'] ) ) {
			$this->deactivate_license();
			delete_option( 'weddingpress_license' );
			delete_option( 'weddingpress_license_status' );
		}
	}

	public function updated_license( $option_name, $old_value, $value ) {
		if ( isset( $_POST['wdp_elementor_activate'] ) ) {
			$this->activate_license();
		}
		if ( isset( $_POST['wdp_elementor_deactivate'] ) ) {
			$this->deactivate_license();
			delete_option( 'weddingpress_license' );
			delete_option( 'weddingpress_license_status' );
		}
	}
	
	public function status_field() {
		if ( $this->is_active() ) {
			echo '<p><strong>Cek status sistem website anda, agar elementor bisa berkerja dengan optimal</strong></p>';
			echo '<p>WeddingPress Version : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.WEDDINGPRESS_ELEMENTOR_VERSION.'</span></p>';
			
			echo '<p>Elementor Version : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.ELEMENTOR_VERSION.'</span></p>';

			$phpmemory = ini_get( 'memory_limit' );
			$phpmemory_num = str_replace( 'M', '', $phpmemory );
			if ( $phpmemory_num >= 256 ) {
				echo '<p>PHP Memory Limit : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$phpmemory.'</span></p>';
			}
			else {
				echo '<p>PHP Memory Limit : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$phpmemory.'</span></p>';
				echo '<p style="color: #7d8183;font-size: 0.9em">PHP Memory Limit minimum 64M ke atas, direkomendasikan 256M, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';
			}

			$wpmemory = WP_MEMORY_LIMIT;
			$wpmemory_num = str_replace( 'M', '', $wpmemory );
			if ( $wpmemory_num >= 256 ) {
				echo '<p>WordPress Memory Limit : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$wpmemory.'</span></p>';
			}
			else {
				echo '<p>WordPress Memory Limit : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$wpmemory.'</span></p>';
				echo '<p style="color: #7d8183;font-size: 0.9em">WordPress Memory Limit minimum  256M, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';
			}


			$maxexectime = ini_get( 'max_execution_time' );
			if ( $maxexectime >= 300 ) {
				echo '<p>PHP Max Execution Time : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$maxexectime.'</span></p>';
			}
			else {
				echo '<p>PHP Max Execution Time : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$maxexectime.'</span></p>';
				echo '<p style="color: #7d8183;font-size: 0.9em">PHP Max Execution Time direkomendasikan 300, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';

				
			}

			$maxinputvars = ini_get( 'max_input_vars' );
			$check['data'] = $maxinputvars;
			if ( $maxinputvars >= 1000 ) {
				echo '<p>PHP Max Input Time : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$check['data'].'</span></p>';
			}
			else {
				echo '<p>PHP Max Input Time : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$check['data'].'</span></p>';
				echo '<p style="color: #7d8183;font-size: 0.9em">PHP Max Input Time direkomendasikan 1000, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';
				
			}

			$postmaxsize = ini_get( 'post_max_size' );
			$check['data'] = $postmaxsize;
			if ( $postmaxsize >= 64 ) {
				echo '<p>PHP Post Max Size : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$check['data'].'</span></p>';
			}
			else {
				echo '<p>PHP Post Max Size : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$check['data'].'</span></p>';
				echo '<p style="color: #7d8183;font-size: 0.9em">PHP Post Max Size minimum 64M ke atas, direkomendasikan 64M, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';
				
			}

			$maxuploadsize = wp_max_upload_size();
			$check['data'] = size_format( $maxuploadsize );
			if ( $maxuploadsize >= 64000000 ) {
				echo '<p>Max Upload Size : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$check['data'].'</span></p>';
			}
			else {
				echo '<p>Max Upload Size : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$check['data'].'</span></p>';
				echo '<p style="color: #7d8183;font-size: 0.9em">Max Upload Size minimum 64M ke atas, direkomendasikan 64M, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';
			}

			$curlversion = curl_version();
			$check['data'] = $curlversion['version'].', '.$curlversion['ssl_version'];
			echo '<p>cURL Version : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$check['data'].'</span></p>';


			$response = wp_remote_get( 'https://weddingpress.co.id/wp-json/template/v1/info', [
				'timeout' => 60,
				'body' => [
					// Which API version is used
					'api_version' => WEDDINGPRESS_ELEMENTOR_VERSION,
					// Which language to return
					'site_lang' => get_bloginfo( 'language' ),
				],
			]
			);

			if ( is_wp_error( $response ) ) {
				echo '<p>WeddingPress Library : <span class="wdp-elementor-error"><i class="dashicons dashicons-dismiss"></i>&nbsp;NOT CONNECTED'. $response->get_error_message() .'</span></p>';
			}

			$http_response_code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== (int) $http_response_code ) {
			$error_msg = 'HTTP Error (' . $http_response_code . ')';
				echo '<p>WeddingPress Library : <span class="wdp-elementor-error"><i class="dashicons dashicons-dismiss"></i>&nbsp;NOT CONNECTED'. $error_msg .'</span></p>';
			}

			$library_data = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( empty( $library_data ) ) {
				echo '<p>WeddingPress Library : <span class="wdp-elementor-error"><i class="dashicons dashicons-dismiss"></i>&nbsp;NOT CONNECTED</span></p>';
				echo '<p style="color: #7d8183;font-size: 0.9em">tidak ada template yang tersedia, silahkan hubungi support!</p>';
			}
			else {
				echo '<p>WeddingPress Library : <span class="wdp-elementor-yes"><i class="dashicons dashicons-yes-alt"></i>&nbsp;CONNECTED</span></p>';
				echo '<p class="wdp-elementor-yes">Alhamdulillah! WeddingPress siap untuk digunakan.</p>';
			}
			

			$library_template = 0;
			$library_block = 0;
			if ( isset( $library_data['templates'] ) && !empty($library_data['templates']) ) {
				foreach ( $library_data['templates'] as $template ) {
					if ( $template['type'] == 'section' ) {
						$library_template++;
					}
				}
			}
			if ( isset( $library_data['tags'] ) && !empty($library_data['tags']) ) {
				foreach ( $library_data['tags'] as $template ) {
					$library_block++;
				}
			}
			if ( $library_template || $library_block ) {
				$library_template ? $library_template.' templates' : '';
				echo '<p>WeddingPress Templates : <span class="wdp-elementor-yes"><i class="dashicons dashicons-admin-page"></i>&nbsp;'.$library_template.' Templates</span></p>';
				$library_block ? $library_block.' blocks/sections' : '';
				echo '<p>WeddingPress Categories Templates : <span class="wdp-elementor-yes"><i class="dashicons dashicons-open-folder"></i>&nbsp;'.$library_block.' Categories</span></p>';
				
			}

		}
		
	}

	/**
	 * Hidden License Key
	 *
	 * since 1.0.0
	 */
	private function get_hidden_license( $license ) {
		if ( !$license )
			return $license;
		$start = substr( $license, 0, 5 );
		$finish = substr( $license, -5 );
		$license = $start.'xxxxxxxxxxxxxxxxxxxx'.$finish;
		return $license;
	}	

	public function setup_fields() {
		$fields = array(
			array(
				'label' => esc_html__( 'Kode Licensi', 'weddingpress' ),
				'id' => 'weddingpress_license',
				'type' => 'license',
				'section' => 'weddingpress_elementor_license',
			)
		);
		if ( $this->is_active() ) {
			$fields[] = array(
				'label' => esc_html__( 'System Info', 'weddingpress' ),
				'id' => 'weddingpress_status',
				'type' => 'status',
				'section' => 'weddingpress_elementor_status',
			);
			$fields[] = array(
				'label'       => esc_html__( 'Pilih CommentKit Versi', 'weddingpress' ),
				'id'          => 'comment_type',
				'desc'        => '',
				'type'        => 'select',
				// 'default'     => 'commentkit',
				'options'     => array(
					'' => 'Pilih',
					'commentkit' => 'Comment Kit',
					'commentkit2'  => 'Comment Kit 2',
				),
				'section'     => 'weddingpress_elementor_status',
			);
		
		}

		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'field_callback' ), 'wdp_elementor', $field['section'], $field );
			if ( 'note' != $field['type'] ) {
				if ( false === strpos( $field['id'], '[' ) ) {
					register_setting( 'wdp_elementor', $field['id'] );
				}
				else {
					$a = explode( '[', $field['id'] );
					$b = trim( $a[0] );
					register_setting( 'wdp_elementor', $b );
				}
			}
		}
		
	}
	

	public function guestbook_box_submit(){		
		
		if(empty($_POST['guestbook-name'])) wp_die();
		if(empty($_POST['guestbook-message'])) wp_die();
		
		$data_array = get_option('post_guestbook_box_data'.$_POST['id'],array());		
		$data = array(
			'name' => $_POST['guestbook-name'],
			'message' => $_POST['guestbook-message'],
			'confirm' => $_POST['confirm'],
		);
		
		$data_array[] = $data;
		update_option('post_guestbook_box_data'.$_POST['id'], $data_array);
		$avatar = $_POST['avatar'];
		
		?>						
			<div class="user-guestbook">
				<div><img src="<?php echo $avatar; ?>"></div>
				<div class="guestbook">
					<a class="guestbook-name"><?php echo str_replace("\\", "", htmlspecialchars ($data['name']))?></a><span class="wdp-confirm"><i class="fas fa-check-circle"></i> <?php echo $data['confirm']?></span>
					<div class="guestbook-message"><?php echo str_replace("\\", "", htmlspecialchars ($data['message']))?></div>
				</div>
			</div>
		
		<?php 
		
		wp_die();
	}

	public function field_callback( $field ) {
		if ( false === strpos( $field['id'], '[' ) ) {
			$value = get_option( $field['id'] );
		}
		else {
			$a = explode( '[', $field['id'] );
			$b = trim( $a[0] );
			$c = trim( str_replace( ']', '', $a[1] ) );
			$d = get_option( $b );
			$value = isset( $d[$c] ) ? $d[$c] : false;
		}
		$defaults = array(
			'label'			=> '',
			'label2'		=> '',
			'type'			=> 'text',
			'default'		=> '',
			'desc'			=> '',
			'placeholder'	=> '',
			'field_class'	=> '',
		);
		$field = wp_parse_args( $field, $defaults );
		$field['db'] = $field['id'];
		$field['id'] = str_replace( array( '[', ']' ), '_', $field['id'] );
		switch ( $field['type'] ) {
			case 'license':
				$this->license_field();
				break;
			case 'status':
				$this->status_field();
				break;
			case 'note':
				printf( '<label for="%1$s">%2$s</label><br/>',
					$field['id'],
					$field['label2']
				);
				break;
			case 'select':
				if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
					$attr = '';
					$options = '';
					foreach( $field['options'] as $key => $label ) {
						$options.= sprintf( '<option value="%s" %s>%s</option>',
							$key,
							selected( $value, $key, false ),
							$label
						);
					}
					printf( '<select name="%1$s" id="%2$s" class="%3$s" %4$s>%5$s</select>',
						$field['db'],
						$field['id'],
						$field['field_class'],
						$attr,
						$options
					);
				}
				break;
			default:
				printf( '<input name="%1$s" id="%2$s" class="%3$s" type="%4$s" placeholder="%5$s" value="%6$s" />',
					$field['db'],
					$field['id'],
					$field['field_class'],
					$field['type'],
					$field['placeholder'],
					$value
				);
		}
		if( $desc = $field['desc'] ) {
			printf( '<p class="description">%s </p>', $desc );
		}
	}

	public function show_invalid_license_notice(){
        if ( !$this->is_active()){
            $class = 'notice notice-error';
            $message = sprintf(__( '<strong>Terima kasih sudah menggunakan WeddingPress</strong> Silahkan %s Aktivasi Lisensi %s untuk mendapatkan update otomatis, support teknis, dan akses WeddingPress.', 'weddingpress' ), " <a href='".admin_url('admin.php?page=weddingpress')."'>", '</a>');

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
        }
    }
	
}


if (did_action('elementor/loaded')) {
$license_status = get_option( 'weddingpress_license_status' );
if ( isset( $license_status->license ) && $license_status->license == 'valid' ) :
	require_once(WEDDINGPRESS_ELEMENTOR_PATH. 'library/weddingpress-library.php');
	require_once(WEDDINGPRESS_ELEMENTOR_PATH. 'library/weddingpress-library-manager.php');
	Elementor\WDP_Templates_Library_Manager::instance();

endif;
}


$license_status = get_option( 'weddingpress_license_status' );
if ( isset( $license_status->license ) && $license_status->license == 'valid' ) :
	if ( did_action( 'elementor/loaded' ) ) {
		include_once( WEDDINGPRESS_ELEMENTOR_PATH . '/extensions/sticky.php' );
		include_once( WEDDINGPRESS_ELEMENTOR_PATH . '/elementor/elementor.php' );
		
	}
endif;

add_action('wp_head', 'weddingpress_preview_elementor');
function weddingpress_preview_elementor() {

    if ( isset( $_GET['elementor-preview'] ) && $_GET['elementor-preview'] ) {
        ?>
        <style>
            #unmute-sound {
                display: block !important;
            }
            #mute-sound {
                display: block !important;
            }
        </style>
        <?php    
    }

}

function get_current_post_id() {
        if (isset(\Elementor\Plugin::instance()->documents)) {
            return \Elementor\Plugin::instance()->documents->get_current()->get_main_id();
        }
        return get_the_ID();
}

function wdp_find_element_recursive($elements, $element_id) {
    foreach ($elements as $element) {
        if ($element_id === $element['id']) {
            return $element;
        }
        if (!empty($element['elements'])) {
            $element = wdp_find_element_recursive($element['elements'], $element_id);
            if ($element) {
                return $element;
            }
        }
    }
    return \false;
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( is_wdp_woocommerce_active() ) {
add_filter( 'wdp_woo_elements_js_localize', 'js_localize' );
}

/**
 * Load Quick View Product.
 *
 * @since 1.3.3
 * @param array $localize localize.
 * @access public
 */
function js_localize( $localize ) {
    
	$localize['is_cart']           = is_cart();
	$localize['is_single_product'] = is_product();
	$localize['view_cart']         = esc_attr__( 'View cart', 'powerpack' );
	$localize['cart_url']          = apply_filters( 'wdp_woocommerce_add_to_cart_redirect', wc_get_cart_url() );
	
	return $localize;
}


/**
 * Is WooCommerce active
 *
 * @return bool
 */
function is_wdp_woocommerce_active() {
	if ( class_exists( 'WooCommerce' ) || is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		return true;
	}

	return false;
}



add_action( 'admin_footer', 'wdp_update_info', 99999 );
function wdp_update_info() {
	$screen = get_current_screen();
	$screen_id = isset($screen->id) ? $screen->id : '';
	if ( !in_array( $screen_id, array( 
		'toplevel_page_weddingpress',
		'weddingpress_page_commentkit-settings',
		'weddingpress_page_wdp_wc_settings',
		'weddingpress_page_widget-manager',
	) ) ) {
		return;
	}
?>
<script>
  var ps_config = {
	workspace_id : "d3a4c490-722f-44d0-8f4f-c7a6f78af8d2"
  };
</script>
<script type="text/javascript" src="https://cdn.productstash.io/js/widget.min.js?v=0.8" defer="defer"></script>
<?php 
}




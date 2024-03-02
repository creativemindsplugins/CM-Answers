<?php



class CMA_Storage {

	private static $base_key_prefix = 'cma_storage_';

	protected static function getKey() {
		if ( ! is_user_logged_in() ) {
			if ( isset( $_COOKIE['PHPSESSID'] ) ) {
				$key = $_COOKIE['PHPSESSID'];
			} else {
				$key = md5( $_SERVER['HTTP_USER_AGENT'] ) . md5( $_SERVER['REMOTE_ADDR'] );
			}

		} else {

			$key = md5( "user_" . get_current_user_id() );
		}

		return self::$base_key_prefix . $key;
	}

	public static function set( $key, $value, $expiration = 0 ) {
		$key = self::getKey() . '_' . $key;
		set_transient( $key, $value, $expiration );
	}


	public static function get( $key, $default = '' ) {
		$res = get_transient( self::getKey() . '_' . $key );

		if ( ! isset( $res ) || empty( $res ) ) {
			return $default;
		}

		return $res;
	}
	
	public static function delete( $key ) {
		$res = delete_transient( self::getKey() . '_' . $key );

		return $res;
	}

	public static function search( $key ) {
		global $wpdb;

		$key = self::getKey() . '_' . $key;

		$query = "SELECT * FROM {$wpdb->prefix}options
				  WHERE option_name LIKE '_transient_{$key}%'";

		$res = $wpdb->get_results( $query );

		if ( ! empty( $res ) ) {
			foreach ( $res as $i => $r ) {
				$name          = str_replace( '_transient_', '', $r->option_name );
				$transient_res = get_transient( $name );

				if ( ! $transient_res ) {
					unset( $res[ $i ] );
				}
			}
		}

		return $res;
	}

}

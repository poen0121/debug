<?php
if (!class_exists('hpl_debug')) {
	include (strtr(dirname(__FILE__), '\\', '/') . '/system/path/main.inc.php');
	/**
	 * @about - debug the operation mode.
	 */
	class hpl_debug {
		/** Set PHP errors report mode.
		 * @access - public function
		 * @param - boolean $switch (open or close the report error mode) : Default true
		 * @note - $switch `true` is open the report error types E_ALL.
		 * @note - $switch `false` is close the report error types 0.
		 * @return - boolean
		 * @usage - hpl_debug::report($switch);
		 */
		public static function report($switch = true) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: bool2error(0)) {
				error_reporting($switch ? E_ALL : 0);
				return ($switch ? self :: is_all_report() : self :: is_close_report());
			}
			return false;
		}
		/** Check the PHP error reporting mode is strictly of type E_ALL.
		 * @access - public function
		 * @return - boolean
		 * @usage - hpl_debug::is_all_report();
		 */
		public static function is_all_report() {
			if (!hpl_func_arg :: delimit2error()) {
				return (error_reporting() & E_ALL ? true : false);
			}
			return false;
		}
		/** Check the PHP error reporting mode is strictly of type 0.
		 * @access - public function
		 * @return - boolean
		 * @usage - hpl_debug::is_close_report();
		 */
		public static function is_close_report() {
			if (!hpl_func_arg :: delimit2error()) {
				return (error_reporting() === 0 ? true : false);
			}
			return false;
		}
		/** Set PHP errors report display mode.
		 * @access - public function
		 * @param - boolean $switch (open or close the report display mode) : Default true
		 * @note - $switch `true` is open the report display.
		 * @note - $switch `false` is close the report display.
		 * @return - boolean
		 * @usage - hpl_debug::display($switch);
		 */
		public static function display($switch = true) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: bool2error(0)) {
				ini_set('display_errors', $switch);
				return ($switch ? self :: is_display() : !self :: is_display());
			}
			return false;
		}
		/** Check the PHP error report display mode is open.
		 * @access - public function
		 * @return - boolean
		 * @usage - hpl_debug::is_display();
		 */
		public static function is_display() {
			if (!hpl_func_arg :: delimit2error()) {
				if (!self :: is_close_report()) {
					return (bool) preg_match('/^(on|(\+|-)?[0-9]*[1-9]+[0-9]*)$/i', ini_get('display_errors'));
				}
			}
			return false;
		}
		/** Set PHP log errors to specified default file.
		 * @access - public function
		 * @param - string $path (file path)
		 * @return - boolean
		 * @usage - hpl_debug::error_log_file($path);
		 */
		public static function error_log_file($path = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0) && !hpl_func_arg :: string2error(1)) {
				if (isset ($path { 0 }) && !hpl_path :: is_absolute($path) && hpl_path :: is_files($path)) {
					$normPath = hpl_path :: norm($path);
					ini_set('error_log', $normPath);
					if (hpl_path :: norm(ini_get('error_log')) === $normPath) {
						return true;
					}
				}
			}
			return false;
		}
		/** Set PHP error log storage.
		 * #note - Uncontrolled error_log function.
		 * @access - public function
		 * @param - boolean $switch (open or close the logs storage) : Default true
		 * @note - $switch `true` is open the logs storage.
		 * @note - $switch `false` is close the logs storage.
		 * @return - boolean
		 * @usage - hpl_debug::record($switch);
		 */
		public static function record($switch = true) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: bool2error(0)) {
				ini_set('log_errors', $switch);
				return ($switch ? self :: is_record() : !self :: is_record());
			}
			return false;
		}
		/** Check the PHP error log storage mode is open.
		 * @access - public function
		 * @return - boolean
		 * @usage - hpl_debug::is_record();
		 */
		public static function is_record() {
			if (!hpl_func_arg :: delimit2error()) {
				if (!self :: is_close_report()) {
					return (bool) preg_match('/^(on|(\+|-)?[0-9]*[1-9]+[0-9]*)$/i', ini_get('log_errors'));
				}
			}
			return false;
		}
	}
}
?>
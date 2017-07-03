<?php
if (!class_exists('hpl_debug')) {
	include (str_replace('\\', '/', dirname(__FILE__)) . '/system/path/main.inc.php');
	/**
	 * @about - debug the operation mode.
	 */
	class hpl_debug {
		/** Trace error handler.
		 * @access - public function
		 * @param - integer $errno (error number)
		 * @param - string $message (error message)
		 * @param - string $file (file path)
		 * @param - integer $line (file line number)
		 * @return - boolean|null
		 * @usage - set_error_handler('hpl_debug::TraceErrorHandler');
		 */
		public static function TraceErrorHandler($errno = null, $message = null, $file = null, $line = null) {
			if (!(error_reporting() & $errno)) {
				// This error code is not included in error_reporting
				return;
			}
			//response message
			$title = '';
			switch ($errno) {
				case E_PARSE :
				case E_ERROR :
				case E_CORE_ERROR :
				case E_COMPILE_ERROR :
				case E_USER_ERROR :
					$title = 'Fatal error';
					break;
				case E_WARNING :
				case E_USER_WARNING :
				case E_COMPILE_WARNING :
				case E_RECOVERABLE_ERROR :
					$title = 'Warning';
					break;
				case E_NOTICE :
				case E_USER_NOTICE :
					$title = 'Notice';
					break;
				case E_STRICT :
					$title = 'Strict';
					break;
				case E_DEPRECATED :
				case E_USER_DEPRECATED :
					$title = 'Deprecated';
					break;
				default :
					$title = 'Error [' . $errno . ']';
					break;
			}
			$message = '<br /><b>' . $title . '</b>: ' . $message . ' in <b>' . $file . '</b> on line <b>' . $line . '</b><br />';
			if ((isset ($_SERVER['ERROR_STACK_TRACE']) ? preg_match('/^(on|(\+|-)?[0-9]*[1-9]+[0-9]*)$/i', $_SERVER['ERROR_STACK_TRACE']) : false)) { //error stack trace
				$baseDepth = 1;
				$caller = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
				$rows = count($caller);
				if ($rows > $baseDepth) {
					$message .= PHP_EOL . 'Stack trace:' . PHP_EOL . '<br />';
					for ($i = $baseDepth; $i < $rows; $i++) {
						$argsList = ''; //args info
						if (isset ($caller[$i]['args'])) {
							foreach ($caller[$i]['args'] as $sort => $args) {
								$argsList .= ($sort > 0 ? ', ' : '');
								switch (gettype($args)) {
									case 'string' :
										$argsList .= '\'' . (mb_strlen($args, 'utf-8') > 20 ? mb_substr($args, 0, 17, 'utf-8') . '...' : $args) . '\'';
										break;
									case 'array' :
										$argsList .= 'Array';
										break;
									case 'object' :
										$argsList .= get_class($args) . ' Object';
										break;
									case 'resource' :
										$argsList .= get_resource_type($args) . ' Resource';
										break;
									case 'boolean' :
										$argsList .= ($args ? 'true' : 'false');
										break;
									case 'NULL' :
										$argsList .= 'NULL';
										break;
									default :
										$argsList .= $args;
										break;
								}
							}
						}
						$message .= '#' . ($i - $baseDepth) . ' ' . $caller[$i]['file'] . '(' . $caller[$i]['line'] . '):' . (isset ($caller[$i]['class']) ? ' ' . $caller[$i]['class'] . $caller[$i]['type'] : ' ') . $caller[$i]['function'] . '(' . $argsList . ')' . ($i < ($rows -1) ? PHP_EOL : '') . '<br />';
					}
				}
			}
			if (preg_match('/^(on|(\+|-)?[0-9]*[1-9]+[0-9]*)$/i', ini_get('log_errors'))) {
				error_log('PHP ' . strip_tags($message), 0);
			}
			if (preg_match('/^(on|(\+|-)?[0-9]*[1-9]+[0-9]*)$/i', ini_get('display_errors'))) {
				echo PHP_EOL . (isset ($_SERVER['argc']) && $_SERVER['argc'] >= 1 ? strip_tags($message) : $message) . PHP_EOL;
			}
			if ($title == 'Fatal error') {
				exit;
			}
			/* Don't execute PHP internal error handler */
			return true;
		}
		/** Set the PHP error stack trace mode to initialize the set_error_handler call hp_debug::TraceErrorHandler.
		 * @access - public function
		 * @param - boolean $switch (open or close the stack trace error mode) : Default true
		 * @note - $switch `true` is open $_SERVER['ERROR_STACK_TRACE'] = On.
		 * @note - $switch `false` is close $_SERVER['ERROR_STACK_TRACE'] = Off.
		 * @return - boolean
		 * @usage - hpl_debug::trace_error_handler($switch);
		 */
		public static function trace_error_handler($switch = true) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: bool2error(0)) {
				$_SERVER['ERROR_STACK_TRACE'] = ($switch ? 'On' : 'Off');
				set_error_handler(__CLASS__ . '::TraceErrorHandler');
				return true;
			}
			return false;
		}
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
				ini_set('error_reporting', ($switch ? E_ALL : 0));
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
		 * @param - string $peelName (set the species name to peel off the system error log file) : Default 'PHP' is system reserved words
		 * @note - $peelName use $_SERVER['PEEL_OFF_ERROR_LOG_FILE'] to save the peel off error log file location.
		 * @note - $peelName use $_SERVER['PEEL_OFF_NAME'] to save the peel off name.
		 * @return - boolean
		 * @usage - hpl_debug::error_log_file($path,$peelName);
		 */
		public static function error_log_file($path = null, $peelName = 'PHP') {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0) && !hpl_func_arg :: string2error(1)) {
				if (!isset ($path { 0 })) {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Empty path supplied as input', E_USER_WARNING, 1);
				} else {
					if (!hpl_path :: is_absolute($path) && hpl_path :: is_files($path)) {
						$path = hpl_path :: norm($path);
						$peelName = strtoupper(trim($peelName));
						if ($peelName == 'PHP') {
							ini_set('error_log', $path);
							if (hpl_path :: norm(ini_get('error_log')) === $path) {
								if (isset ($_SERVER['PEEL_OFF_ERROR_LOG_FILE'])) {
									unset ($_SERVER['PEEL_OFF_ERROR_LOG_FILE']);
								}
								if (isset ($_SERVER['PEEL_OFF_NAME'])) {
									unset ($_SERVER['PEEL_OFF_NAME']);
								}
								return true;
							}
						} else {
							$_SERVER['PEEL_OFF_ERROR_LOG_FILE'] = $path;
							$_SERVER['PEEL_OFF_NAME'] = $peelName;
							return true;
						}

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
<?php
	/*
	 *
	 * Stockholms universitet
	 * DSV
	 *
	 * - Konfigurationsfil/Configuration file.
	 *
	 * Do whatever you want to do with this file,
	 * including but not limited to,
	 * burning the contents, erasing, selling and/or modifying it.
	 *
	 */

	define('DB_HOST', '');
	define('DB_NAME', '');
	define('DB_USER', '');
	define('DB_PASS', '');
	define('DB_CHAR', 'utf8');

	define('DAISY_API_USERNAME', '');
	define('DAISY_API_PASSWORD', '');

	/* Session management did not work properly,
	 * therefore CSRF protection is disabled for now.
	*/
	define('DISABLED_CSRF_PROTECTION', true);

?>

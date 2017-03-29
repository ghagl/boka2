<?php
	/*
 	 *
 	 * Stockholms universitet
 	 * DSV
 	 *
 	 * @dsvauthor Gustaf Haglund <ghaglund@dsv.su.se>
 	 * <Please contact Erik Thuning instead.>
 	 *
 	 * Copyright (C) 2017 The Stockholm University
 	 *
 	 * This program is free software: you can redistribute it and/or modify
 	 * it under the terms of the GNU Affero General Public License as published by
 	 * the Free Software Foundation, either version 3 of the License, or
 	 * (at your option) any later version.
 	 *
 	 * This program is distributed in the hope that it will be useful,
 	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 	 * GNU Affero General Public License for more details.
 	 *
 	 * You should have received a copy of the GNU Affero General Public License
 	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 	 */

	define('__ROOT__', __DIR__);

	require_once 'vendor/autoload.php';
	require_once 'api/core/boka.php';
	require_once 'api/core/su.php';

	$templates = new League\Plates\Engine('assets/templates');
	$boka = new Boka();

	$ruser = $_SERVER['REMOTE_USER'];
	$template_vars = array('admin' => ($admin = ($boka->admin($ruser))), 'user' => StockholmsUniversitet::lookupUser($ruser), 'csrf_token' => @$_SESSION['csrf']);

?>

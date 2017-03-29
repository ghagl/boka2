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

	if (!isset($_GET['id'])) {
		header("location: /");
		exit;
	}

	require_once 'base.php';

	$template_vars['products'] = [];
	if (($products = $boka->products($_GET['id'])) !== (NULL || false)) {
		$template_vars = array_merge($template_vars, ['products' => $products]);
	}

	// To be user friendly...
	$template_vars['category'] = $boka->lookupCategory($_GET['id']);

	echo $templates->render('prodview', $template_vars);

?>

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
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="./assets/template.css" />

		<link rel="stylesheet" type="text/css" href="./assets/bootstrap.css" />

		<link rel="stylesheet" type="text/css" href="./assets/boka.css" />
		<link rel="stylesheet" type="text/css" href="./assets/dhtmlxcalendar.css" />
		<script type="text/javascript" src="./assets/js/boka.js"></script>
		<script type="text/javascript" src="./assets/js/3rdparty.js"></script>
		<script type="text/javascript" src="./assets/js/dhtmlxcalendar.js"></script>

		<title><?=$this->e($title)?></title>
	</head>
	<body>
		<div id="container">
			<a class="accessibility-link" accesskey="s" href="#content-top" title="Skip navigation"></a>
			<div id="top-links">&nbsp;</div>
			<div id="header">
				<a id="header-su-responsive" href="https://www.su.se/" title="Stockholms universitets webbplats">
					<img src="./assets/images/su_logo_responsive_sv.png" alt="Stockholms universitet" />
				</a>
				<a id="header-dsv" href="https://dsv.su.se/" title="Till DSV:s webbplats" accesskey="1">
					<img src="./assets/images/dsv_logo_sv.png" alt="Institutionen för data- och systemvetenskap">
				</a>
				<a id="header-su" href="http://www.su.se/" title="Stockholms universitets webbplats">
					<img src="./assets/images/su_logo_sv.gif" alt="Stockholms universitet">
				</a>
				<div class="clear">
				</div>
			</div>
			<div id="contents">
				<a class="accessibility-link" name="content-top"></a>
				<div id="centerContent" class="bokaMenu">
					<a href="./">Produktkategorier</a>
					<?php if ($admin): ?>| <a href="./admin.php">Aktiva utlån</a> | <a href="./admin.php?history=true">Gamla lån</a> | <a href="./admin_objects.php">Redigera objekt</a><?php endif; ?>
				</div>
				<div id="<?php if (@$centerContent): ?>center<?php endif ?>Content">
					<?=$this->section('content')?>
				</div>
			</div>
			<div class="clear"/>
			<div id="footer">
				<div id="footer-name">
					<div id="footer-dsv">
						Institutionen för data- och systemvetenskap
					</div>
					<div id="footer-su">
						Stockholms universitet
					</div>
				</div>
				<div id="footer-contact">
					<a id="footer-contact-link" href="https://dsv.su.se/omdsv/kontakt" accesskey="7">Kontakt</a>
				</div>
				<div class="clear">
				</div>
			</div>
		</div>
	</body>
</html>

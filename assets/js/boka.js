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

"use strict";

var list_of_loans = [];

function removeByAttr(element, index, value)
{
	for (var i = 0; i < element.length; ++i) {
		if (element[i].hasOwnProperty(index) && element[i][index] === value) {
			element.splice(i, 1);
		}
	}
}

function findAttrIndex(element, index, value)
{
	for (var i = 0; i < element.length; ++i) {
		if (element[i].hasOwnProperty(index) && element[i][index] === value) {
			return i;
		}
	}

	return null;
}

function searchBox()
{
	var text = document.getElementById('searchBox').value;
	var tdnames = document.getElementsByClassName('tdname');

	for (var a = 0; a < tdnames.length; ++a) {
		if (tdnames[a].innerText.toLocaleLowerCase().indexOf(text.toLocaleLowerCase()) == -1) {
			tdnames[a].parentElement.style = "display:none;";
		} else {
			tdnames[a].parentElement.style = "";
		}
	}
}

function searchBoxProducts()
{
	var text = document.getElementById('searchBox').value;
	var parent = document.getElementById('productParent');
	var param = 'search='+text;
	var xmlhttp = new XMLHttpRequest();

	if (text === '' || text == ' ') {
		if (list_of_loans.length == 0) {
			document.getElementById('productSearch').style = 'display: none;';
			document.getElementById('searchNotice').style = 'display:none;';
		}
		document.getElementById('regularTable').style = '';
		parent.innerHTML = '';
		return;
	}

	document.getElementById('regularTable').style = 'display:none;';
	document.getElementById('searchNotice').style = '';

	xmlhttp.open('POST', './api/productSearch.php');
    xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState > 3 && xmlhttp.status === 200)
		{
			/* Clean up for eventual old search results... */
			parent.innerHTML = '';

			document.getElementById('productSearch').style = '';
			var json = JSON.parse(xmlhttp.responseText);
			var products = json['result'];

			for (var product in products) {
				var tr = document.createElement('tr');
				var pid = products[product]['id'];
				var pname = products[product]['name'];

				tr.innerHTML =
					'<td>'+'<a onclick="loanOut(\''+pid+'\')" href="javascript:void();">'+pname+'</a></td>'+
					'<td>'+products[product]['information']+'</td>';

				if (json['admin'] == true) {
					tr.innerHTML += '<td>'+'<input id=\"'+pid+'_checkbox\" type=\"checkbox\" '+((findAttrIndex(list_of_loans, 'id', pid) !== null) ? 'checked=\"checked\"' : '')+' onclick=\"markLoan('+pid+', \''+pname+'\')\"/></td>';
				} else {
					if (products[product]['available'] == 0) {
						tr.innerHTML += '<td>Inte tillgänglig</td>';
					} else if (products[product]['available'] == 1) {
						tr.innerHTML += '<td>Du har redan lånat</td>';
					} else {
						tr.innerHTML += '<td>Tillgänglig</td>';
					}
				}

				parent.appendChild(tr);
			}
		}
		if (xmlhttp.readyState > 3 && xmlhttp.status !== 200) {
			alert('Något konstigt hände ('+xmlhttp.responseText+'). Kontakta Erik Thuning');
			return;
		}
	};

	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(param);
}

function searchBoxDaisy()
{
	var text = document.getElementById('searchBox').value;
	var parent = document.getElementById('daisyParent');
	var param = 'search='+text;
	var xmlhttp = new XMLHttpRequest();

	if (text === '' || text == ' ') {
		document.getElementById('daisySearch').style = 'display: none;';
		parent.innerHTML = '';
		return;
	}

	console.log(text);

	xmlhttp.open('POST', './api/daisySearch.php');
    xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState > 3 && xmlhttp.status === 200)
		{
			/* Clean up for eventual old search results... */
			parent.innerHTML = '';

			document.getElementById('daisySearch').style = '';
			var persons = JSON.parse(xmlhttp.responseText)['result'];

			for (var person in persons) {
				var tr = document.createElement('tr');
				tr.innerHTML =
					'<td>'+'<a onclick="loanOut(\''+persons[person]['email']+'\')" href="javascript:void();">'+persons[person]['firstName']+' '+persons[person]['lastName']+'</a></td>'+
					'<td>'+persons[person]['email']+'</td>';
				parent.appendChild(tr);
			}
		}
		if (xmlhttp.readyState > 3 && xmlhttp.status !== 200) {
			alert('Något konstigt hände ('+xmlhttp.responseText+'). Kontakta Erik Thuning');
			return;
		}
	};

	//xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(param);
}

function markLoan(id, pname)
{
	var elem = document.getElementById(id+'_checkbox').checked;
	var markInfo = document.getElementById('informMarkedLoans');

	if (elem) {
		document.getElementById('bulkButtonNotice').style = 'display:none;';
		document.getElementById('bulkLoanButton').style = '';
		document.getElementById('bulkListNotice').style = '';

		list_of_loans.push({id: id, pname: pname});
		markInfo.innerHTML += '<div class="eraseLink" id="'+id+'_pname">'+((list_of_loans.length > 1) ? ', ' : '')+pname+'<a style="color:green;" href="javascript:void(0)" title="Ta bort" onclick="eraseLoan('+id+')"> x'+((list_of_loans.length !== 1) ? ', ' : '')+'</a></div>';
	} else {
		eraseLoan(id);
	}

	console.log(list_of_loans);
}

function eraseLoan(id)
{
	var elem = document.getElementById(id+'_pname');
	removeByAttr(list_of_loans, 'id', id);
	elem.parentNode.removeChild(elem);

	if (list_of_loans.length === 0) {
		document.getElementById('bulkLoanButton').style = 'display:none;';
		document.getElementById('bulkListNotice').style = 'display:none;';
	}

	document.getElementById(id+'_checkbox').checked = false;
}

function loanOutBulk()
{
	window.location.href = './admin_loan.php?id='+JSON.stringify(list_of_loans);
}

function loanOut(person_email)
{
	/* Checks the date field */
	var datefield = document.getElementById('dateBox').value;
	if (datefield.length !== 10) {
		alert("Vänligen fyll i ett datum efter formatet");
		return;
	}

	if (person_email == "null") {
		alert("Personen du lånar ut till måste ha en giltig e-post (i Daisy). Kontakta Erik Thuning");
		return;
	}

	var xmlhttp = new XMLHttpRequest();
	var productID = document.getElementById('productID').value;
	var param = 'email='+person_email+'&date='+datefield+'&product='+productID;

	xmlhttp.open('POST', './api/loanOut.php');
    xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState > 3 && xmlhttp.status === 200) {
			//alert(xmlhttp.responseText);
			window.location.href = './admin.php?loanSuccess=true';
		} else if (xmlhttp.status !== 200) {
			alert('Något hände ('+xmlhttp.responseText+'). Kontakta Erik Thuning');
		}
	};

	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(param);
}

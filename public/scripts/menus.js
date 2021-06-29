/*
Copyright 2021 Jolan Aklin and Yohan Zbinden

This website is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, version 3 of the License.

This website is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this software.  If not, see <https://www.gnu.org/licenses/>.
*/

var isMenuOpen = false;
window.addEventListener('resize', CloseMenu);
function OpenMenu() {
	var navbarChildren = document.getElementById("navBar").children;
	if(isMenuOpen) {
		for (let i = 1; i < navbarChildren.length-1; i++) {
			if(navbarChildren[i].id != "profile-button") {
				navbarChildren[i].style.display = "";
				navbarChildren[i].style.flexBasis = "";
				navbarChildren[i].style.margin = "";
			}
		}
		isMenuOpen = false;
	}else{
		for (let i = 1; i < navbarChildren.length-1; i++) {
			if(navbarChildren[i].id != "profile-button") {
				navbarChildren[i].style.display = "block";
				navbarChildren[i].style.flexBasis = "100%";
				navbarChildren[i].style.margin = "10px 0px 0px 0px";
			}
		}
		isMenuOpen = true;
	}
}
function CloseMenu () {
	if(isMenuOpen) {
		OpenMenu();
	}
}

function OpenFilterMenu (id) {
	var filterMenu = document.getElementById(id);
	filterMenu.style.display = "block";
	filterMenu.style.position = "fixed";
}
function CloseFilterMenu (id) {
	var filterMenu = document.getElementById(id);
	filterMenu.style.display = "";
	filterMenu.style.position = "";
}

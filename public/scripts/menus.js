var isMenuOpen = false;
window.addEventListener('resize', CloseMenu);
function OpenMenu() {
	var navbarChildren = document.getElementById("navBar").children;
	if(isMenuOpen) {
		for (let i = 2; i < navbarChildren.length; i++) {
			navbarChildren[i].style.display = "";
			navbarChildren[i].style.flexBasis = "";
			navbarChildren[i].style.margin = "";
		}
		isMenuOpen = false;
	}else{
		for (let i = 2; i < navbarChildren.length; i++) {
			navbarChildren[i].style.display = "block";
			navbarChildren[i].style.flexBasis = "100%";
			navbarChildren[i].style.margin = "10px 0px 0px 0px";
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

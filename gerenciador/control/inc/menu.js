var prefixMenu = "tbl_menu_";
var prefixDiv = "div_";
var prefixSubmenu = "div_submenu_";

function onMenu(menu, focus){
	var tblMenu = document.getElementById(prefixMenu+menu);
	var div = document.getElementById(prefixDiv+menu);
	
	if(tblMenu) {
		if(focus){
			tblMenu.style.border = " 1px solid #8B9F5D ";
			tblMenu.className = "menu menu_sel";
		} else {
			tblMenu.style.border = " 1px solid #CCCCCC ";
			tblMenu.className = "menu";
		}
	}
}

function onSubmenu(menu, focus){
	var divSubmenu = document.getElementById(prefixSubmenu+menu);
	if(divSubmenu)
		if(focus){
			divSubmenu.style.border = " 1px solid #A4B57C ";
		} else {
			divSubmenu.style.border = " 1px solid #CCCCCC ";
		}
}
// JavaScript Document
// JavaScript Document
top.window.moveTo(0,0)

if (document.all) {
	//si es el IE, usamos resizeTo para redimensionar
	top.window.resizeTo(screen.availWidth,screen.availHeight)

} else if ( document.layers || document.getElementById ) {
	//si Navigator, modificamos los valores de outerHeight y outerWidth	
	if ( top.window.outerHeight < screen.availHeight || top.window.outerWidth < screen.availWidth ) {
		top.window.outerWidth = screen.availWidth
		top.window.outerHeight = screen.availHeight
	}
}
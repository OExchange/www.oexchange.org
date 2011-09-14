var attachEventListener = function (a,b,c,d) {
	a.addEventListener ? a.addEventListener (b,c,d) : !a.attachEvent || a.attachEvent("on"+b,c)
}

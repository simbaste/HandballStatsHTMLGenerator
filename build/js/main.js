function setColors(url) {
    var regColor = /^([0-9a-f]{6}|[0-9a-f]{3})$/i;

    var colorsParams = new URLSearchParams(url);
    var pcolor = colorsParams.get('pcolor');
    var scolor = colorsParams.get('scolor');

    if (regColor.test(pcolor)) {
	console.log(pcolor);
	$('.container th').css('background-color', "#"+pcolor);
    }
    if (regColor.test(scolor)) {
	console.log(scolor);
    }
}

setColors(window.location.search);

function resizeImages() {
	for (var i = 0; i < document.images.length ;i++){
		if (document.images[i].className == 'resizeImage') {
			var imageWidth = document.images[i].width;
			var imageHeight = document.images[i].height;
			
			if ((imageMaxWidth != 0 && imageWidth > imageMaxWidth) || (imageMaxHeight != 0 && imageHeight > imageMaxHeight)) {
				if (imageMaxWidth != 0) var div1 = imageMaxWidth / imageWidth;
				else var div1 = 1;
				if (imageMaxHeight != 0) var div2 = imageMaxHeight / imageHeight;
				else var div2 = 1;
							
				if (div1 < div2) {
					document.images[i].width = imageMaxWidth;
					document.images[i].height = Math.round(imageHeight * div1);
				}
				else {
					document.images[i].height = imageMaxHeight;
					document.images[i].width = Math.round(imageWidth * div2);
				}
				
				if (!isLinked(document.images[i])) {
					var popupLink = document.createElement("a");
					popupLink.setAttribute('href', document.images[i].src);
					popupLink.setAttribute('target', '_blank');
					popupLink.appendChild(document.images[i].cloneNode(true));
					
					document.images[i].parentNode.replaceChild(popupLink, document.images[i]);
				}
			}
		}
	}
}

function isLinked(node) {
	do {
		node = node.parentNode;
		if (node.nodeName == 'A') return true;
	}
	while (node.nodeName != 'TD' && node.nodeName != 'BODY');
		
	return false;
}
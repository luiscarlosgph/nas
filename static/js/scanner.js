function refreshScannerList() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

      	// Getting <ul> tag with the list of scanners
			var scannerList = document.getElementById('scanner-list')

			// Reading and splitting scanners from server
			var scanners = xmlhttp.responseText.split('\n');
			
			// Removing previous <li> elements, scanners may be disconnected
			while (scannerList.firstChild) {
				scannerList.removeChild(scannerList.firstChild);
			}
			
			// If any scanner detected
			if (scanners[0] != 'None') {
				// For each line in the response to the query we will create a <li> tag inside of the <ul>
				for (var i = 0; i < scanners.length; i++) {
					var li = document.createElement('option');
					li.innerHTML = scanners[i];
					li.appendChild(document.createTextNode(scanners[i]));
					scannerList.appendChild(li);
				}
			}
		}
	}		
	xmlhttp.open('GET', '/scanners/scannerList', true);
	xmlhttp.send();
}

// Updating date and time
var refreshInterval = 2000; // ms
refreshScannerList();
setInterval(refreshScannerList, refreshInterval);

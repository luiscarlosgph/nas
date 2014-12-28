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
			
			// For each line in the response to the query we will create a <li> tag inside of the <ul>
			for (var i = 0; i < scanners.length; i++) {
				var li = document.createElement('option');
				li.appendChild(document.createTextNode(scanners[i]));
				scannerList.appendChild(li);
			}
		}
	}		
	xmlhttp.open('GET', '/scanners/scannerList', true);
	xmlhttp.send();
}

function scan() {
	// Changing the scan button to animate it while scanning 
	var scanBtn = document.getElementById('scanner-scan');
	scanBtn.innerHTML = 'SCANNING... <i class="glyphicon glyphicon-refresh icon-refresh-animate"></i>'
	
	// Getting the device name of the scanner currently selected by the user
	var scannerList = document.getElementById('scanner-list')
	
	if (scannerList.selectedIndex == -1)
		return null;

	// Ask server to scan
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			location.reload();
		}
	}		
	xmlhttp.open('GET', '/scanners/scan/?s=' + scannerList.options[scannerList.selectedIndex].text, true);
	xmlhttp.send();
}

function deletePicture(picname) {
	if (confirm('Are you sure that you want to delete this picture?')) {
		// Ask server to scan
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				location.reload();
			}
		}		
		xmlhttp.open('GET', '/scanners/deletePicture/?p=' + picname, true);
		xmlhttp.send();
	}
}

// Updating date and time
var refreshInterval = 1000; // ms
refreshScannerList();
setInterval(refreshScannerList, refreshInterval);

// Assigning DOM event handler to the scan button
document.getElementById('scanner-scan').onclick = function() { scan() };

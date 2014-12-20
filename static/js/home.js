function refreshDateTime() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      	document.getElementById('datetime-text').innerHTML = xmlhttp.responseText;
		}
	}		
	xmlhttp.open('GET', '/home/datetime', true);
	xmlhttp.send();
}

function refreshUptime() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      	document.getElementById('uptime-text').innerHTML = xmlhttp.responseText;
		}
	}		
	xmlhttp.open('GET', '/home/uptime', true);
	xmlhttp.send();
}

function refreshCpuUsage() { 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      	document.getElementById('cpu-usage-meter').style.width = xmlhttp.responseText;
      	document.getElementById('cpu-usage-text').innerHTML = xmlhttp.responseText;
		}
	}		
	xmlhttp.open('GET', '/home/cpuUsage', true);
	xmlhttp.send();
}

function refreshMemoryUsage() { 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      	document.getElementById('memory-usage-meter').style.width = xmlhttp.responseText;
      	document.getElementById('memory-usage-text').innerHTML = xmlhttp.responseText;
			// setTimeout(refreshCpuUsage(refreshInterval), refreshInterval);
		}
	}		
	xmlhttp.open('GET', '/home/memoryUsage', true);
	xmlhttp.send();
}

function refreshDiskUsage() { 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      	document.getElementById('disk-usage-meter').style.width = xmlhttp.responseText;
      	document.getElementById('disk-usage-text').innerHTML = xmlhttp.responseText;
			// setTimeout(refreshCpuUsage(refreshInterval), refreshInterval);
		}
	}		
	xmlhttp.open('GET', '/home/diskUsage', true);
	xmlhttp.send();
}

// Updating date and time
var refreshInterval = 1000; // ms
refreshDateTime();
setInterval(refreshDateTime, refreshInterval);

// Updating uptime
var refreshInterval = 1000; // ms
refreshUptime();
setInterval(refreshUptime, refreshInterval);

// Updating CPU usage
refreshInterval = 1000; // ms
refreshCpuUsage();
setInterval(refreshCpuUsage, refreshInterval);

// Updating memory usage
refreshMemoryUsage();
setInterval(refreshMemoryUsage, refreshInterval);

// Updating disk usage
refreshDiskUsage();
setInterval(refreshDiskUsage, refreshInterval);

$(window).bind("load", function () {
	var footer = $("#footer");
	var pos = footer.position();
	var height = $(window).height();
	height = height - pos.top;
	height = height - footer.height();
	if (height > 0) {
		footer.css({ 'margin-top': height + 'px' });
	}
});

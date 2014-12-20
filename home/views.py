from django.shortcuts import render
from django.http import HttpResponse
from datetime import timedelta
import psutil
import subprocess
import re
import time

def home(request):
	return render(request, 'home/index.html')

def datetime(request):
	return HttpResponse(time.strftime("%a %d %b %Y - %H:%M:%S"))

def uptime(request):
	with open('/proc/uptime', 'r') as f:
		uptimeSecs = float(f.readline().split()[0])
	uptimeStr = str(timedelta(seconds = uptimeSecs))
	return HttpResponse(uptimeStr.split('.')[0])

def cpuUsage(request):
	return HttpResponse(str(int(psutil.cpu_percent(interval = 1) + 0.5)) + '%')

def memoryUsage(request):
	return HttpResponse(str(int(psutil.virtual_memory()[2] + 0.5)) + '%')

def diskUsage(request):
	cmdOutput = subprocess.Popen(['df', '-h', '/dev/sda1'], stdout = subprocess.PIPE).communicate()[0]
	p = re.compile('\s\d+\%\s')
	return HttpResponse(p.findall(cmdOutput)[0].strip())

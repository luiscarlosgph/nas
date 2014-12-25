from django import template
from datetime import timedelta
import subprocess
import re
import psutil
import time

register = template.Library()

@register.simple_tag
def datetime():
	return time.strftime("%a %d %b %Y - %H:%M:%S")

@register.simple_tag
def uptime():
	with open('/proc/uptime', 'r') as f:
		uptimeSecs = float(f.readline().split()[0])
	uptimeStr = str(timedelta(seconds = uptimeSecs))
	return uptimeStr.split('.')[0]

@register.simple_tag
def cpuUsage():
	return str(int(psutil.cpu_percent(interval = 1) + 0.5)) + '%'

@register.simple_tag
def memoryUsage():
	return str(int(psutil.virtual_memory()[2] + 0.5)) + '%'

@register.simple_tag
def diskUsage():
	cmdOutput = subprocess.Popen(['df', '-h', '/dev/sda1'], stdout = subprocess.PIPE).communicate()[0]
	p = re.compile('\s\d+\%\s')
	return p.findall(cmdOutput)[0].strip()

from django import template
from datetime import timedelta
import subprocess
import re
import psutil

register = template.Library()

@register.simple_tag
def uptime():
	with open('/proc/uptime', 'r') as f:
		uptimeSecs = float(f.readline().split()[0])
	uptimeStr = str(timedelta(seconds = uptimeSecs))
	return uptimeStr.split('.')[0]

@register.simple_tag
def memoryUsage():
	cmdOut = subprocess.Popen(['free', '-m'], stdout = subprocess.PIPE).communicate()[0]
	cacheLine = cmdOut.splitlines(4)[2]
	p = re.compile('\d+')
	line = p.findall(cacheLine)
	used = float(line[0])
	free = float(line[1])
	percentage = int(((used / (used + free)) * 100) + 0.5);
	return str(percentage) + '%' 

@register.simple_tag
def diskUsage():
	cmdOutput = subprocess.Popen(['df', '-h', '/dev/sda1'], stdout = subprocess.PIPE).communicate()[0]
	p = re.compile('\s\d+\%\s')
	return p.findall(cmdOutput)[0].strip()

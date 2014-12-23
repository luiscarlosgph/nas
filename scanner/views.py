from django.shortcuts import render
from django.http import HttpResponse
import subprocess
import re

'''
For this code to work:

1) The user running the web server (www-data) must be in the group lp.
2) The command scanimage -L must be available.

'''

def show(request):
	return render(request, 'scanner/index.html')

def scannerList(request):
	cmdOut = subprocess.Popen(['scanimage', '-L'], stdout = subprocess.PIPE).communicate()[0]
	ret = 'None'
	m = re.match('device.+is\sa\s(.+)$', cmdOut)
	# TODO: support more than one scanner
	if (m):
		ret = m.group(1)
	return HttpResponse(ret.replace('_', ' '))

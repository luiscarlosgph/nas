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
	listOfMatches = re.findall('device.+is\sa\s(.+)$', cmdOut)
	if (len(listOfMatches) > 0):
		ret = '\n'.join(listOfMatches)
	return HttpResponse(ret.replace('_', ' '))

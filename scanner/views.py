from django.shortcuts import render
from django.http import HttpResponse
import subprocess
import re
import random
import string
import time

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
	listOfMatches = re.findall('device\s.(.+).\sis\sa\s.+$', cmdOut)
	# listOfMatches = re.findall('device\s.+\sis\sa\s(.+)$', cmdOut)
	if (len(listOfMatches) > 0):
		ret = '\n'.join(listOfMatches)
	return HttpResponse(ret)

def scan(request):
	scannerProvided = request.GET.get('s', 'error')

	# If the scanner is not valid we do not do anything 
	valid = False
	cmdOut = subprocess.Popen(['scanimage', '-L'], stdout = subprocess.PIPE).communicate()[0]
	listOfMatches = re.findall('device\s.(.+).\sis\sa\s.+$', cmdOut)
	for match in listOfMatches:
		if (scannerProvided == match):
			valid = True
			break
	if (not valid):
		return render(request, 'scanner/index.html')

	# Now that we know that the name of the scanner provided is valid, we can scan
	cmdOut = subprocess.Popen(['scanimage', '--resolution=300', '-d', scannerProvided], stdout = subprocess.PIPE).communicate()[0]
	
	# Writing image to file
	randstr = ''.join([random.choice(string.ascii_letters + string.digits) for n in xrange(10)])
	filePath = '/tmp/' + randstr + '.ppm'
	f = open(filePath, 'w')
	f.write(cmdOut)
	f.close()
	
	# Converting image in PPM format to JPG
	newFilePath = '/mnt/raid/scanner/' + time.strftime("%a %d %b %Y - %H:%M:%S") + '.jpg'
	subprocess.Popen(['convert', '-quality', '60', filePath, newFilePath], stdout = subprocess.PIPE).communicate()[0]

	return HttpResponse('OK')

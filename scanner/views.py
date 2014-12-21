from django.shortcuts import render
from django.http import HttpResponse
import subprocess

def show(request):
	return render(request, 'scanner/index.html')

def scannerList(request):
	cmdOutput = subprocess.Popen(['scanimage', '-L'], stdout = subprocess.PIPE).communicate()[0]
	return HttpResponse(cmdOutput)

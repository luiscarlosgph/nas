from django.shortcuts import render
from django.http import HttpResponse
import os
import time
import threading

#def detached(argc, argv):

def show(request):
	#argc = 22
	#argv = 10
	#t = threading.Thread(target = detached, args = (argc, argv))
	#t.daemon = True
	#t.start()
	return render(request, 'notepad/index.html')

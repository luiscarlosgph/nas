from django.shortcuts import HttpResponseRedirect
from django.shortcuts import render
from django.http import HttpResponse
from subprocess import Popen, PIPE

def login(request):
	username = request.POST['user']
	password = request.POST['pass']
	output = Popen(['sudo', '/var/www/authentication/pamtest.py', username, password], stdout=PIPE).communicate()[0]
	if (output == 'OK'):
		request.session['user'] = username
		return render(request, 'home/index.html')
	else:
		request.session.pop('user', None)
		return HttpResponseRedirect('/')

def logout(request):
	request.session.pop('user', None)
	return HttpResponseRedirect('/')

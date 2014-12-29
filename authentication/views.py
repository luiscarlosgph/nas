from django.shortcuts import HttpResponseRedirect
from subprocess import Popen, PIPE

def login(request):
	username = request.POST['user']
	password = request.POST['pass']
	output = Popen(['sudo', '/var/www/authentication/pamtest.py', username, password], stdout=PIPE).communicate()[0]
	if (output == 'OK'):
		request.session['user'] = username
		return HttpResponseRedirect('/')
	else:
		request.session.pop('user', None)
		return HttpResponseRedirect('/')
#		return render(request, 'authentication/login_fail.html')

def logout(request):
	request.session.pop('user', None)
	return HttpResponseRedirect('/')

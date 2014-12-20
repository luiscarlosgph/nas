from django.shortcuts import render
from django.http import HttpResponse

def manager(request):
	return render(request, 'download_manager/index.html')

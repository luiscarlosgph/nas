from django.shortcuts import render
from django.http import HttpResponse

def show(request):
	return render(request, 'file_explorer/index.html')

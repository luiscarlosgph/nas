from django.shortcuts import render
from django.http import HttpResponse
from datetime import timedelta

def show(request):
	return render(request, 'task/index.html')

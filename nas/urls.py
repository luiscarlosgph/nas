from django.conf.urls import patterns, include, url
from django.contrib import admin
from django.conf import settings
from django.conf.urls.static import static

urlpatterns = patterns('',
    # Examples:
    # url(r'^blog/', include('blog.urls')),

    url(r'^$', 'home.views.home', name='home'),
	 url(r'^home/datetime/$', 'home.views.datetime', name='datetime'),
	 url(r'^home/uptime/$', 'home.views.uptime', name='uptime'),
	 url(r'^home/cpuUsage/$', 'home.views.cpuUsage', name='cpuUsage'),
	 url(r'^home/memoryUsage/$', 'home.views.memoryUsage', name='memoryUsage'),
	 url(r'^home/diskUsage/$', 'home.views.diskUsage', name='diskUsage'),
	 url(r'^download-manager/$', 'download_manager.views.manager', name='downloadManager'),
	 url(r'^music-player/$', 'music_player.views.show', name='musicPlayer'),
	 url(r'^notepad/$', 'notepad.views.show', name='notepad'),
	 url(r'^scanners/$', 'scanner.views.show', name='scanner'),
	 url(r'^scanners/scannerList/$', 'scanner.views.scannerList', name='scannerList'),
	 url(r'^scanners/scan/', 'scanner.views.scan', name='scan'),
	 url(r'^scanners/deletePicture/', 'scanner.views.deletePicture', name='deletePicture'),
	 url(r'^printers/$', 'printer.views.show', name='printer'),
	 url(r'^file-explorer/$', 'file_explorer.views.show', name='fileExplorer'),
	 url(r'^tasks/$', 'task.views.show', name='task'),
	 url(r'^alarms/$', 'alarm.views.show', name='alarm'),
	 url(r'^pdf-creator/$', 'pdf_creator.views.show', name='pdfCreator'),
	 url(r'^authentication/login/$', 'authentication.views.login', name='login'),
	 url(r'^logout/$', 'authentication.views.logout', name='authenticateLogout'),
#    url(r'^admin/$', include(admin.site.urls)),
) + static(settings.STATIC_URL, document_root=settings.STATIC_ROOT)

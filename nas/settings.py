"""
Django settings for nas project.

For more information on this file, see
https://docs.djangoproject.com/en/1.7/topics/settings/

For the full list of settings and their values, see
https://docs.djangoproject.com/en/1.7/ref/settings/
"""

# Build paths inside the project like this: os.path.join(BASE_DIR, ...)
import os
BASE_DIR = os.path.dirname(os.path.dirname(__file__))


# Quick-start development settings - unsuitable for production
# See https://docs.djangoproject.com/en/1.7/howto/deployment/checklist/

# SECURITY WARNING: keep the secret key used in production secret!
SECRET_KEY = 'x)%ds@7oct$i8-_$j@s@)e1pke@qdm%t1izd8ro!hjs3+t$vj='

# SECURITY WARNING: don't run with debug turned on in production!
DEBUG = True

TEMPLATE_DEBUG = True

ALLOWED_HOSTS = []


# Application definition

INSTALLED_APPS = (
#    'django.contrib.admin',
#    'django.contrib.auth',
    'django.contrib.contenttypes',
    'django.contrib.sessions',
    'django.contrib.messages',
    'django.contrib.staticfiles',
	 'home',
	 'music_player',
	 'scanner',
	 'download_manager',
	 'notepad',
	 'printer',
	 'file_explorer',
	 'task',
	 'alarm',
	 'pdf_creator',
	 'authentication',
)

MIDDLEWARE_CLASSES = (
    'django.contrib.sessions.middleware.SessionMiddleware',
    'django.middleware.common.CommonMiddleware',
    'django.middleware.csrf.CsrfViewMiddleware',
    'django.contrib.auth.middleware.AuthenticationMiddleware',
    'django.contrib.auth.middleware.SessionAuthenticationMiddleware',
    'django.contrib.messages.middleware.MessageMiddleware',
    'django.middleware.clickjacking.XFrameOptionsMiddleware',
	 'django.contrib.sessions.middleware.SessionMiddleware',
)

ROOT_URLCONF = 'nas.urls'

WSGI_APPLICATION = 'nas.wsgi.application'


# Database
# https://docs.djangoproject.com/en/1.7/ref/settings/#databases

DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.sqlite3',
        'NAME': os.path.join(BASE_DIR + '/db/', 'db.sqlite3'),
    }
}

# Internationalization
# https://docs.djangoproject.com/en/1.7/topics/i18n/

LANGUAGE_CODE = 'en-us'

TIME_ZONE = 'UTC'

USE_I18N = True

USE_L10N = True

USE_TZ = True

# Static files (CSS, JavaScript, Images)
# https://docs.djangoproject.com/en/1.7/howto/static-files/

STATIC_URL = '/static/'
STATIC_ROOT = '/var/www/static/'
STATICFILES_DIRS = (
	os.path.join(BASE_DIR, "static"),
	'/var/www/static/',
)

SETTINGS_PATH = os.path.normpath(os.path.dirname(__file__))
# Find templates in the same folder as settings.py.
TEMPLATE_DIRS = (
	os.path.join(SETTINGS_PATH + '/../', 'templates'),
)

TEMPLATE_CONTEXT_PROCESSORS = (
	'django.core.context_processors.debug',
	'django.core.context_processors.i18n',
	'django.core.context_processors.media',
	'django.core.context_processors.request',
)

# DJANGO_WYSIWYG_FLAVOR = 'ckeditor'
# CKEDITOR_UPLOAD_PATH = 'uploads/'


from .base import *


# SECURITY WARNING: don't run with debug turned on in production!
DEBUG = True

ALLOWED_HOSTS = []


CORS_ALLOWED_ORIGINS = [
    'http://localhost:80',  
]



# Database
DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.sqlite3',
        'NAME': BASE_DIR / '../db.sqlite3',
    }
}



# Static files (CSS, JavaScript, Images) and Media files (Images, Videos, etc.)

STATIC_URL = 'static/'
MEDIA_URL = 'media/'

MEDIA_ROOT = os.path.join(BASE_DIR, '../media')
STATIC_ROOT = os.path.join(BASE_DIR, '../static')


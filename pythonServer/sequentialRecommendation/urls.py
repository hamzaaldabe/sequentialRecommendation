
from django.contrib import admin
from django.urls import path
from . import views


app_name = 'sequentialRecommendation'
urlpatterns = [
    path('test/',views.test,name='test'),
    path('forme/',views.recommend,name='recommend')

]

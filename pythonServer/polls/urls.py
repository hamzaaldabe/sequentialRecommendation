
from django.contrib import admin
from django.urls import path
from . import views


app_name = 'polls'
urlpatterns = [

    path('questions/', views.questions_list, name='questions_list'),
    path('question/add/', views.add_question, name='add_question'),
    path('choice/delete/<int:choice_id>/', views.delete_choice, name='delete_choice'),
    path('choice/add/', views.add_choice, name='add_choice'),
    path('choice/increment/', views.increment_choice_votes, name='increment_choice_votes'),
    path('test/',views.test,name='test'),

]



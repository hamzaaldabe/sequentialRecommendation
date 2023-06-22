from django.shortcuts import render
from rest_framework.decorators import api_view
from django.http import JsonResponse
from rest_framework.response import Response
import json

# Create your views here.



@api_view(['POST'])
def test(request):
    # dict={'key':1,'name':'value'}
    # data=request.POST
    # print(data)
    data=json.loads(request.body)
    print(data)
    return JsonResponse(json.dumps(data), safe=False)

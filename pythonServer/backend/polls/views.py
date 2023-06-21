from rest_framework.decorators import api_view
from django.http import JsonResponse
from .models import Question, Choice
from .serializers import QuestionSerializer, ChoiceSerializer
from rest_framework.response import Response
import json
@api_view(['GET'])
def questions_list(request):
    questions = Question.objects.all()
    serializer = QuestionSerializer(questions, many=True)
    return JsonResponse(serializer.data, safe=False)


@api_view(['POST'])
def add_question(request):
    serializer = QuestionSerializer(data=request.data)
    if serializer.is_valid():
        serializer.save()
        return Response(serializer.data, status=201)
    return Response(serializer.errors, status=400)

@api_view(['POST'])
def add_choice(request):
    serializer = ChoiceSerializer(data=request.data)
    if serializer.is_valid():
        serializer.save()
        return Response(serializer.data, status=201)
    return Response(serializer.errors, status=400)




# delete choice
@api_view(['DELETE'])
def delete_choice(request, choice_id):
    try:
        choice = Choice.objects.get(pk=choice_id)
    except Choice.DoesNotExist:
        return Response(status=404)

    choice.delete()
    return Response(status=204)









@api_view(['POST'])
def increment_choice_votes(request):
    choice_id = request.data.get('choice_id')
    try:
        choice = Choice.objects.get(pk=choice_id)
    except Choice.DoesNotExist:
        return Response(status=404)

    choice.votes += 1
    choice.save()

    serializer = ChoiceSerializer(choice)
    return Response(serializer.data)

@api_view(['POST'])
def test(request):
    zbi={'key':1,'name':'zbi'}
    data=request.POST
    print(data['123'])
    return JsonResponse(json.dumps(zbi), safe=False)









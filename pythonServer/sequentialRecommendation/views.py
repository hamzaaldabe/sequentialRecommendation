import sys
sys.path.insert(1, '/home/hamza/Desktop/sequentialRecommendation/')
from django.shortcuts import render
from rest_framework.decorators import api_view
from django.http import JsonResponse
from rest_framework.response import Response
import json
import pickle
from src.Args import Args
import torch
import torch.nn as nn
import numpy

from src.models.sequential.GRU4Rec import GRU4Rec
# Create your views here.

userList={}
lastItem={}
historyItems={}

def runModel(feed_dict):
    model_path = '/home/hamza/Desktop/sequentialRecommendation/model/GRU4Rec/GRU4Rec__ml-1m__0__lr=0.001__l2=0.0001__emb_size=64__hidden_size=100.pt'
    args = Args()
    model = GRU4Rec(args=args,corpus=pickle.load(open('/home/hamza/Desktop/sequentialRecommendation/data/ml-1m/SeqReader.pkl', 'rb')))
    model.load_state_dict(torch.load(model_path))
    model.eval()
    output = model.forward(feed_dict)
    predict = output['prediction'].detach().numpy()
    print(predict)

def process_json_response(json_response):

    data = json.loads(json_response)
    movie_id = data["movie"]["MovieID"]
    session_id = data["movie"]["sessionId"]
    user_id = data["movie"]["userID"]
    timestamp = data["movie"]["timestamp"]
    user_id = data["movie"]["userID"]

    
    if user_id not in userList:
        userList[user_id] = []
    userList[user_id].append(data)
    historyItems[user_id].append(data["movie"]["MovieID"])
    lastItem[user_id].append(data["movie"]["MovieID"])



def get_gru4rec_inputs(user_id, session_ids, item_ids, timestamps):
    inputs = {
        "user_id": user_id,
        "session_ids": session_ids,
        "item_ids": item_ids,
        "timestamps": timestamps
    }
    return inputs


@api_view(['POST'])
def test(request):
    # dict={'key':1,'name':'value'}
    # data=request.POST
    # print(data)

    userID = request.body
    data=json.loads(request.body)
    movie_id = data["movie"]["MovieID"]
    session_id = data["movie"]["sessionId"]
    user_id = data["movie"]["userID"]
    timestamp = data["movie"]["timestamp"]
    
    if user_id not in userList:
            userList[user_id] = []
    if user_id not in lastItem:
            lastItem[user_id] = []
    if user_id not in historyItems:
            historyItems[user_id] = []

    data_string = json.dumps(data)
    process_json_response(data_string)
    
    feed_dict = {}

    new_history = []
    last_item = []
    for user_id, responses in historyItems.items():
        # print("User ID:", user_id)
        # print("Movies:")
        for response in responses:
            new_history.append(response)

    new_history.pop()    
    # new_history.pop()


    # feed_dict = {
    #     'item_id': torch.tensor([1]),
    #     'history_items': torch.tensor(new_history),  # Example historical item sequence
    #     'lengths': torch.tensor([len(new_history)])  # Length of the historical item sequence
    # }
    item_ids = torch.tensor([[1, 2, 3], [4, 5, 6]])  # Example item IDs, shape: [batch_size, -1]
    history_items = torch.tensor([[7, 8], [9, 10]])  # Example historical items, shape: [batch_size, history_max]
    lengths = torch.tensor([2, 2])  # Example lengths, shape: [batch_size]

    feed_dict = {
        'item_id': item_ids,
        'history_items': history_items,
        'lengths': lengths,
        'batch_size' : torch.tensor(2)
    }
    runModel(feed_dict=feed_dict)
    return JsonResponse(json.dumps(data), safe=False)

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
import numpy as np
from src.models.sequential.GRU4Rec import GRU4Rec

# Create your views here.

userList={}
lastItem={}
historyItems={}
recommended_movie_ids = []
def runModel(feed_dict):
    model_path = '/home/hamza/Desktop/sequentialRecommendation/model/GRU4Rec/GRU4Rec__ml-1m__0__lr=0.001__l2=0.0001__emb_size=64__hidden_size=100.pt'
    args = Args()
    model = GRU4Rec(args=args,corpus=pickle.load(open('/home/hamza/Desktop/sequentialRecommendation/data/ml-1m/SeqReader.pkl', 'rb')))
    model.load_state_dict(torch.load(model_path))
    model.eval()
    output = model.forward(feed_dict)
    predict = output['prediction'].detach().numpy()
    formatted_prediction = np.array2string(predict, precision=2, suppress_small=True)
    # Assuming your prediction tensor is named "prediction"
    top_k_values, top_k_indices = torch.topk(output['prediction'], k=15)

    # Convert the indices to actual movie IDs
    recommended_movie_ids = top_k_indices.squeeze().tolist()

    print(recommended_movie_ids)


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
    historyItems[user_id].append(int(data["movie"]["MovieID"]))
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
def recommended(request):
    
    return JsonResponse(recommended_movie_ids,safe=False)
    
@api_view(['POST'])
def test(request):
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
        print("User ID:", user_id)
        print("Movies:")
        for response in responses:
            new_history.append(response)

    print(new_history)
    # Define the input data

    # Convert the input data to tensors
    item_ids = torch.tensor(range(1, 3000)).view(-1, 1).long()  # All movie IDs in the dataset
    history_items = torch.tensor([new_history])  # Convert the list of history items to a tensor

    # Compute the length of the history
    lengths = torch.tensor([len(history_items[0])])

    # Create the feed_dict
    feed_dict = {
        'item_id': item_ids,
        'history_items': history_items,
        'lengths': lengths,
        'batch_size': torch.tensor(1)
    }

    runModel(feed_dict=feed_dict)
    return JsonResponse(json.dumps(data), safe=False)

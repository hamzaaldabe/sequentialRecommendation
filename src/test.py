from models.sequential.GRU4Rec import GRU4Rec
from models import BaseModel
import torch
import torch.nn as nn
import argparse
import main
import pickle
from Args import Args
model_path = '/home/hamza/Desktop/sequentialRecommendation/model/GRU4Rec/GRU4Rec__ml-1m__0__lr=0.001__l2=0.0001__emb_size=64__hidden_size=100.pt'

args = Args()
model = GRU4Rec(args=args,corpus=pickle.load(open('/home/hamza/Desktop/sequentialRecommendation/data/ml-1m/SeqReader.pkl', 'rb')))
model.load_state_dict(torch.load(model_path))
model.eval()




import torch

class Args:
    args_dict = {
        'emb_size': 64,
        'hidden_size': 100,
        'lr': 1e-3,
        'l2': 1e-4,
        'history_max': 20,
        'dataset': 'ml-1m',
    }

    def __init__(self):
        self.device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
        self.model_path = "/home/hamza/Desktop/sequentialRecommendation/model/GRU4Rec/GRU4Rec__ml-1m__0__lr=0.001__l2=0.0001__emb_size=64__hidden_size=100.pt"
        self.buffer = True
        self.emb_size = Args.args_dict['emb_size']
        self.hidden_size = Args.args_dict['hidden_size']
        self.lr = Args.args_dict['lr']
        self.l2 = Args.args_dict['l2']
        self.history_max = Args.args_dict['history_max']
        self.dataset = Args.args_dict['dataset']
        self.num_neg = 0
        self.dropout = 0
        self.test_all = 0
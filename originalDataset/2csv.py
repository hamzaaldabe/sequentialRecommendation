import csv

input_file = '/home/hamza/Desktop/sequentialRecommendation/originalDataset/ml-1m/ml-1m/movies.dat'
output_file = '/home/hamza/Desktop/sequentialRecommendation/originalDataset/movies.csv'

with open(input_file, 'r', encoding='latin-1') as file:
    lines = file.readlines()

movies = []
for line in lines:
    parts = line.strip().split('::')
    movie_id = int(parts[0])
    movie_title = parts[1].strip('*')
    movies.append((movie_id, movie_title))

with open(output_file, 'w', newline='', encoding='utf-8') as file:
    writer = csv.writer(file)
    writer.writerow(['MovieID', 'Title'])
    writer.writerows(movies)

print(f"Successfully saved {len(movies)} movies to {output_file}.")
import requests
from bs4 import BeautifulSoup
import json
import os

# Target websites (list of URLs to scrape)
urls = [
    "https://goku.sx/movies",
    "https://goku.sx/genre/action-10?page=2",
    "https://goku.sx/genre/science-fiction-5"
]

# List to store all movie data
all_movies = []

# Headers to mimic a browser
headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
}

for url in urls:
    try:
        print(f"Scraping: {url}")
        # Send HTTP GET request with headers
        response = requests.get(url, headers=headers)
        response.raise_for_status()

        # Parse HTML
        soup = BeautifulSoup(response.text, "html.parser")

        # Find all movie items
        movies = soup.find_all("div", class_="item")

        for movie in movies:
            # Movie title
            title_tag = movie.find("h3", class_="movie-name")
            title = title_tag.text.strip() if title_tag else "N/A"

            # Year and duration
            info_split = movie.find("div", class_="info-split")
            year, duration = "N/A", "N/A"
            if info_split:
                divs = info_split.find_all("div")
                if len(divs) >= 2:
                    year = divs[0].text.strip()
                    duration = divs[2].text.strip() if len(divs) > 2 else "N/A"

            # Rating
            rating_tag = movie.find("div", class_="is-rated")
            rating = rating_tag.text.strip() if rating_tag else "N/A"

            # Image URL
            img_tag = movie.find("img")
            image_url = img_tag["src"] if img_tag else "N/A"

            # Movie link
            link_tag = movie.find("a", class_="movie-link")
            link = "https://goku.sx" + link_tag["href"] if link_tag else "N/A"

            # Skip if any required field is N/A
            if title == "N/A" or year == "N/A" or duration == "N/A" or rating == "N/A" or image_url == "N/A" or link == "N/A":
                continue

            # Add data to list
            all_movies.append({
                "title": title,
                "year": year,
                "duration": duration,
                "rating": rating,
                "image": image_url,
                "link": link
            })

    except requests.exceptions.RequestException as e:
        print(f"Error scraping {url}: {e}")
        continue

# Remove duplicates based on title
unique_movies = []
seen_titles = set()
for movie in all_movies:
    if movie['title'] not in seen_titles:
        unique_movies.append(movie)
        seen_titles.add(movie['title'])

# Sort movies by title
unique_movies.sort(key=lambda x: x['title'])

# Save data to JSON file in the parent directory
output_path = os.path.join(os.path.dirname(__file__), '..', 'movies.json')
with open(output_path, "w", encoding="utf-8") as f:
    json.dump(unique_movies, f, ensure_ascii=False, indent=4)

print(f"✅ Saved {len(unique_movies)} unique movies to movies.json")

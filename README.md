# Movie Finding Made Easy

A sleek, responsive website that helps users discover movies and series effortlessly. Built with HTML, CSS, JavaScript, and PHP for intuitive search, dynamic content, and smooth navigation.

## Features

- **Movie Search**: Search for movies by title with real-time filtering.
- **Responsive Design**: Optimized for desktop, tablet, and mobile devices.
- **Dynamic Content**: Movies loaded from a JSON file for easy updates.
- **Contact Form**: Functional contact form with email sending capabilities.
- **Web Scraper**: Python script to scrape and update movie data.

## Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Data**: JSON
- **Scraping**: Python (BeautifulSoup, Requests)
- **Styling**: Custom CSS with dark cinematic theme

## Dependencies

To run this project, you need the following dependencies installed:

- **PHP**: Version 7.0 or higher (for server-side processing)
- **Python**: Version 3.x (for the web scraper)
  - `requests` library: `pip install requests`
  - `beautifulsoup4` library: `pip install beautifulsoup4`
- **Web Server**: Apache, Nginx, or PHP's built-in server (`php -S`)
- **Browser**: Any modern web browser (Chrome, Firefox, Safari, Edge)

## Pages

### index.php
The main homepage featuring:
- Hero section with search functionality
- Grid display of featured movies loaded from `movies.json`
- Search bar that filters movies by title (case-insensitive, partial matches)
- Responsive movie cards with images, titles, ratings, and links to external sites

### about.html
Static page providing information about the project:
- Mission statement
- Technologies used
- Design philosophy
- Developer credits (Information Technology Diploma project)

### contact.php
Interactive contact page with:
- Contact form for sending messages (name, email, message)
- Form validation and error handling
- Success/error messages after submission
- Contact information display

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/Movie_Finding_Made_Easy.git
   cd Movie_Finding_Made_Easy
   ```

2. Ensure you have PHP installed (version 7.0 or higher).

3. Start a local PHP server:
   ```bash
   php -S localhost:8000
   ```

4. Open your browser and navigate to `http://localhost:8000/index.php`

## Usage

- **Home Page**: Browse featured movies or use the search bar to find specific titles.
- **Search**: Enter a movie title in the search box and click "Search" to filter results.
- **About**: Learn more about the project and technologies used.
- **Contact**: Send inquiries via the contact form.

## File Structure

```
Movie_Finding_Made_Easy/
├── index.php              # Main homepage with search functionality
├── about.html             # About page
├── contact.php            # Contact page with form
├── movies.json            # Movie data
├── css/
│   └── style.css          # Main stylesheet
├── js/
│   └── script.js          # JavaScript for interactivity
├── images/
│   ├── logo.png           # Site logo
│   └── 1.jpg              # Background image
├── web_scraper/
│   └── movie_scraper.py   # Python script for scraping movie data
└── README.md              # This file
```

## License

MIT License

Copyright (c) 2025 MFME Team

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## Acknowledgments

- Movie data sourced from various online databases
- Icons and images used are for demonstration purposes
- Built as part of a web development project

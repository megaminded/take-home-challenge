
  # About the project 📝  
  A backend system built with Laravel that fetches articles from selected data sources

  ## Get Started 🚀  
  Install Dependencies
  ~~~
  composer install 
  ~~~
  Start the artisan server
  ~~~
    php artisan serve
  ~~~
  Start the schedule worker
  ~~~
    php artisan schedule:work
  ~~~
  
  ## API Routes 🔥  
  Returns recent news in all categories
  -api/news/category 

  Returns news based on search query
  -api/news/date

  Returns news based on selected category
  -api/news/index 

  Returns news based on selected source
  -api/news/search

  Returns news based on selected date
  -api/news/source 

    
## Approach to development
    - Define News Article Model
    - Create Service class that implements an Interface for each API provider
    - Define controller methods for each API end points based on search queries and user preferences.
    - Create schedule and command class
    - Write a feature to test.

### Please note
The API key for each data source is hardcoded here for simplicity and quick access during development.
For production or sensitive applications, I usually avoid hardcoding API keys or secrets directly in the codebase.

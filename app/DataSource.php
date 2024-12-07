<?php

namespace App;

enum DataSource: String
{
    case NewsAPI = "https://newsapi.org/v2/top-headlines?country=us&apiKey=";
    case NYK = 'https://api.nytimes.com/svc/mostpopular/v2/viewed/30.json?api-key=';
    // case = ;
}

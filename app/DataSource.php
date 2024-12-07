<?php

namespace App;

enum DataSource: String
{
    case NewsAPI = "https://newsapi.org/v2/top-headlines?country=us&apiKey=";
    case NYK = 'New York Times';
}

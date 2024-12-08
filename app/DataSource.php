<?php

namespace App;

enum DataSource: String
{
    case NEWS_API = "News API.org";
    case NEW_YORK_TIMES = 'New York Times';
    case THE_GUARDIAN =  "The Guardian News";
}

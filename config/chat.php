<?php

return [
    "domain"=>"http://apichat.amatai.net",
    'connection' => [       
        'key' => env('CHAT_APP_KEY'),
        'password' => env('CHAT_APP_SECRET'),
        'code' => env('CHAT_APP_ID'),        
    ]
];
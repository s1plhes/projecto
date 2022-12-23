<?php



$apiToken = "5951786342:AAHzrnP5uLOX0wCe561OQ_oll2iG0CXnEHw";
$data = [
    'chat_id' => '-1001874923508',
    'text' => 'testing!'
];

return $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" .
                               http_build_query($data) );

//Gallery carousel with bootstrap?




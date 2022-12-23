$steamapikey="F44FBD8CF9A495B935D672A22B8B897D";
$steamid= "76561198147494892";
$json = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$steamapikey&steamids=$steamid","jsonp");
$utf8 = utf8_decode($json); 
$data = json_decode($utf8,TRUE);
$avatar = $data["response"]["players"]["0"]["avatarfull"];

echo <<<avatar
    <img scr="$avatar">
avatar;
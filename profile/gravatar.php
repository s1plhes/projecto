<?php
// Create connection
	
	/**
	 * Get either a Gravatar URL or complete image tag for a specified email address.
	 *
	 * @param string $email The email address
	 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
	 * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
	 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
	 * @param boole $img True to return a complete IMG tag False for just the URL
	 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
	 * @return String containing either just a URL or a complete image tag
	 * @source https://gravatar.com/site/implement/images/php/
	 */
	
	function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
		$url = 'https://www.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $email ) ) );
		$url .= "?s=$s&d=$d&r=$r";
		if ( $img ) {
			$url = '<img src="' . $url . '"';
			foreach ( $atts as $key => $val )
				$url .= ' ' . $key . '="' . $val . '"';
			$url .= ' />';
		}
		return $url;
	}


function user_avatar($user_avatar_id){
	if(isset($user_avatar_id))
	{
		$usersession = $user_avatar_id;
		$sql = mysqli_query(conn,"SELECT email FROM accounts WHERE id=\"$usersession\" OR username=\"$usersession\";");
		$result = mysqli_fetch_assoc($sql);
		$usergravataremail = $result["email"];
		$email = $usergravataremail;
		$default = "https://miro.medium.com/max/640/1*W35QUSvGpcLuxPo3SRTH4w.webp";
		$size = 400;
		$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
		
		return $grav_url;

	} else {
		echo'Error gravatar';
	}
}



?>
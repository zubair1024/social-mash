<?php
  // Remember () to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
  require_once('php-sdk/facebook.php');

  $facebook = new Facebook(array(
		'appId'  => '706942112669859',
		'secret' => 'aed5fb900bdfd589cfa171c3ebdc7e18'
	));

  
?>
<html>
  <head></head>
  <body>

  <?php
  $user_id = $facebook->getUser();
    if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $user_profile = $facebook->api('/me','GET');
        echo "Name: " . $user_profile['name'];
		$user_graph = $facebook->api('/me?fields=id,name,education,favorite_athletes,hometown,location,likes,feed.limit(30)','GET');
		echo "<b>DATA:<b><br><br><br><pre>",print_r($user_graph),"</pre>";

      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $loginUrl = $facebook->getLoginUrl(array(
			'diplay'=>'popup',
			'scope'=>'email',
			'redirect_uri' => 'https://social-mash.herokuapp.com'
			//'redirect_uri' => 'http://apps.facebook.com/myappsourcephp'
		));
        echo '<p><a href="', $loginUrl, '" target="_top">login</a></p>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    } else {

      // No user, print a link for the user to login
      $loginUrl = $facebook->getLoginUrl(array(
			'diplay'=>'popup',
			//'scope'=>'read_mailbox,read_stream,read_friendlists,read_insights',
			'scope'=>'user_about_me, user_actions.books, user_actions.music, user_actions.news, user_actions.video, user_activities, user_birthday, user_checkins, user_education_history, user_events, user_friends, user_games_activity, user_groups, user_hometown, user_interests, user_likes, user_location, user_notes, user_online_presence, user_photo_video_tags, user_photos, user_questions, user_relationship_details, user_relationships, user_religion_politics, user_status, user_subscriptions, user_videos, user_website, user_work_history',
			'redirect_uri' => 'http://apps.facebook.com/myappsourcephp'
		));
      echo '<p><a href="', $loginUrl, '" target="_top">login</a></p>';

    }

  ?>

  </body>
</html>
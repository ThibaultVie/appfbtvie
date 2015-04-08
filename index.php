<?php
	session_start();
	//Installation SDK FACEBOOK
	require("facebook-php-sdk-v4-4.0-dev/autoload.php");
	const APPID = "861220733950202";
	const APPSECRET = "ed986c548bc2808f694ce6cbb13bb5fa";

	//Initialiser le PHP SDK
	use Facebook\FacebookSession;
	use Facebook\FacebookRequestException;
	FacebookSession::setDefaultApplication(APPID, APPSECRET);

	//Générer l'url de connexion
	use Facebook\FacebookRedirectLoginHelper;
	$redirectUrl = 'http://localhost/';
	$helper = new FacebookRedirectLoginHelper($redirectUrl);
	$loginUrl = $helper->getLoginUrl(['email, user_birthday']);

	//Récupérer les informations de session Facebook et les associer à la session courante


	if (isset($_SESSION) && isset($_SESSION['fb_token'])) {
		$session = new FacebookSession($_SESSION['fb_token']);
	}
	else {
		$session = $helper->getSessionFromRedirect();
	}

	//Afficher le profil utilisateur
	use Facebook\FacebookRequest;
	use Facebook\GraphUser;

	if($session) {

  		try {

   			$user_profile = (new FacebookRequest(
      		$session, 'GET', '/me'
    		))->execute()->getGraphObject(GraphUser::className());

    		echo "Name: " . $user_profile->getName();

  		} catch(FacebookRequestException $e) {

    		echo "Exception occured, code: " . $e->getCode();
    		echo " with message: " . $e->getMessage();

  		}   

	}

?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="UTF-8">
		<title>App Facebook</title>
		<meta name="description" content="Page de test : App Facebook">

		<!-- Setup the Facebook SDK for JavaScript -->

		<script>
		  window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '861220733950202',
		      xfbml      : true,
		      version    : 'v2.3'
		    });
		  };

		  (function(d, s, id){
		     var js, fjs = d.getElementsByTagName(s)[0];
		     if (d.getElementById(id)) {return;}
		     js = d.createElement(s); js.id = id;
		     js.src = "//connect.facebook.net/fr_FR/sdk.js";
		     fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));

		</script>		
	</head>

	<body>
		
		

		<!-- Testez votre intégration à Facebook -->

		<div
		  class="fb-like"
		  data-share="true"
		  data-width="450"
		  data-show-faces="true">
		</div>
		</br>
		<?php
           $loginUrl    = $helper->getLoginUrl(['email,user_birthday']);
           $connectLink = '<a href='.$loginUrl.'>Login</a>';
           echo  $connectLink ;
       	?>

		<div class="fb-comments" data-href="https://appfbtvie.herokuapp.com/" data-numposts="5" data-colorscheme="light"></div>

	</body>

</html>

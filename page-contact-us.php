<?php
 
//response generation function
$response = "";

//function to generate response
function form_response($type, $message){

global $response;

if($type == "success") $response = "<div class='success'>{$message}</div>";
else $response = "<div class='error'>{$message}</div>";

}

//response messages
$not_human       = "Human verification incorrect.";
$missing_content = "Please supply all information.";
$email_invalid   = "Email Address Invalid.";
$name_invalid	 = "Name invalid.";
$message_invalid = "Your message includes invalid characters.";
$message_unsent  = "Message was not sent. Try Again.";
$message_sent    = "Thanks! Your message has been sent.";

//user posted variables
$name = $_POST['message_name'];
$email = $_POST['message_email'];
$message = $_POST['message_text'];
$human = $_POST['message_human'];
$newsletter = $_POST['newsletter_checkbox'];

//php mailer variables
$to = "llmhmd@gmail.com"; //get_option('admin_email');
$subject = "Someone sent a message from ".get_bloginfo('name');
$headers = 'From: '. $email . "\r\n" .
'Reply-To: ' . $email . "\r\n";


//check for humanity
if(!$human == 0){
  if($human != 2) form_response("error", $not_human); //not human!
  else { 
    //validate email
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		  form_response("error", $email_invalid);
		else //email is valid
		{
		  //validate presence of name and message
			if(empty($name) || empty($message)){
			  form_response("error", $missing_content);
			}
		  else //check for junk in the name field
			{
				$npattern = "/^[a-z0-9?-?\'\-\s\p{Arabic}]{2,30}$/";// regex - check english and arabic
				$mpattern = "/^[a-z0-9?-?\"\'\;\:\?\.\,\!\@\$\%\&*\(\)\_\-\=\+\/\s\p{Arabic}]{2,250}$/";// regex - check english and arabic
				if (!preg_match($npattern,$name)){ 
					form_response("error", $name_invalid);
				}
				elseif (!preg_match($mpattern,$message)){ 
					form_response("error", $message_invalid);
				}
				else {		
					//check if they want a newsletter
					$yes = "<strong style=color:red; size:28px;>Add me to your mailing list</strong><\br>";
					if(!empty($newsletter)) {
						$message = $yes+$message;
						return $message;
					}
					$sent = wp_mail($to, $subject, strip_tags($message), $headers);
					if($sent) form_response("success", $message_sent); //message sent!
					else form_response("error", $message_unsent); //message wasn't sent
					echo $name."   ".$email."   ".$message."   ".$newsletter."   ";	
				}
				
			}
		}
	  }
	}
else if ($_POST['submitted']) form_response("error", $missing_content);

?>

<?php get_header(); ?>
 
  <div id="primary" class="site-content">
    <div id="content" role="main">
 
      <?php while ( have_posts() ) : the_post(); ?>
 
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 
            <header class="entry-header">
              <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
 
            <div class="entry-content">
              <?php the_content(); ?>
 
              <style type="text/css">
				  .error{
					padding: 5px 9px;
					border: 1px solid red;
					color: red;
					border-radius: 3px;
				  }
				 
				  .success{
					padding: 5px 9px;
					border: 1px solid green;
					color: green;
					border-radius: 3px;
				  }
				 
				  form span{
					color: red;
				  }
				</style>
				 
				<div id="respond">
				<?php echo $response; ?>
					<form action="<?php the_permalink(); ?>" method="post">
						<p>
						<label for="name">Name: <span>*</span> <br>
							<input type="text" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>">
						</label>
						</p>
						<p>
						<label for="message_email">Email: <span>*</span> <br>
							<input type="text" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>">
						</label>
						</p>
						<p>
						<label for="message_text">Message: <span>*</span> <br>
							<textarea type="text" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea>
						</label>
						</p>
						<p>
						<label for="message_human">Human Verification: <span>*</span> <br>
							<input type="text" style="width: 60px;" name="message_human"> + 3 = 5
						</label>
						<p>
							<input type="checkbox" id="cbox" checked="true" name="newsletter_checkbox"> <label for="cbox">Yes! Sign me up for news from the Center</label>
						</p>
						</p>
							<input type="hidden" name="submitted" value="1">
						<p>
							<input type="submit">
						</p>
					</form>
				</div>
 
            </div><!-- .entry-content -->
 
          </article><!-- #post -->
 
      <?php endwhile; // end of the loop. ?>
 
    </div><!-- #content -->
  </div><!-- #primary -->

  <?php get_footer(); ?>
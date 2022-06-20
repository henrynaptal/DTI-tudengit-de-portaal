<?php
require_once('config.php');
if(isset($_POST['submit']) && $_POST['email']) {
     
  $email = $_POST['email'];

  $result = mysqli_query($conn,"SELECT * FROM users WHERE email='" . $email . "'");

  if(mysqli_num_rows($result) > 0) {
   
      $token = md5($email);
   
      $expiry_time = mktime(date("H", time()+3600), date("i"), date("s"), date("m"), date("d"), date("Y"));
   
      $expiry_date = date("Y-m-d H:i:s", $expiry_time);
   
      $query = mysqli_query($conn, "UPDATE users set  reset_link_token='" . $token . "', expiry_date='" . $expiry_date . "' WHERE email='" . $email . "'");
   
      $link = "<a href='http://greeny.cs.tlu.ee/~hennap/dti_portaal/testmeilisaatmine/reset-password.php?email=%.%24email.%22&token=%22.%24token.%22'>Click To Reset password</a>";

      //Email send code
      $to_email = $email;

      $mail_subject = "Reset Password";
      $mail_content = $link;
      
      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      
      // More headers
      $headers .= "From: no-reply@test.com" . "\r\n";

      // Send email
      if(@mail($to_email, $mail_subject, $mail_content, $headers)) {
          echo "Check your email and click on the link to reset the password.";
      } else {
        echo "Something wrong to send an email. Please try again.";
      }

  } else {
      echo "Invalid Email Address. Go back";
  }

}
?>
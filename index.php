<?php
require_once('core/init.php');
//echo Config::get('mysql/host');// '127.0.0.1'
  if(Sessions::exists('home'))
  {
    echo Sessions::flash('home');
  }
  $user = new User();
  //echo Sessions::get(Config::get('session/session_name'))
  //echo $user->data()->username;
  if($user-> isLoggedIn())
  {
    ?>
    <p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username);?>"><?php echo escape($user->data()->username) ;?></a></p>
    <ul>
      <li><a href="logout.php">Logout</a> </li>
      <li><a href="update.php">Update Details</a> </li>
      <li><a href="changepassword.php">Change Password</a> </li>
    </ul>
    <?php
    if($user->hasPermission('moderator'))
    {
      echo '<p>You Are A Moderators!</p>';
    }
  }
  else
  {
    ?>
   <p>You need to <a href="login.php">Login</a> or <a href="register.php">register</a></p>
    <?php
  }
  ?> 
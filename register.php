<?php
require_once('core/init.php');
//var_dump(Token::check(Input::get('token')));
if(Input::exists())
{
  if(Token::check(Input::get('token')))
  {
   // echo "I have been run";
  $validate = new Validate();
  $validation = $validate->check($_POST,array(
    'username' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 20,
                        'unique' => 'users'),
    'password' => array(
                        'required' => true,
                        'min' => 7),
    'password_again' => array(
                              'required' => true,
                              'matches' => 'password'),
    
    
    'name' => array(
        'required' => true,
        'min' => 2,
        'max' => 50
    )
    
  ));
  if($validation->passed())
  {
  //Sessions::flash('success','You Registered Successfully');
  //header('Location:index.php');
  $user = new user();
 $salt = Hash::salt(32);
  
  try{
    $user->create(array('username' => Input::get('username'),
                        'password' =>Hash::make(Input::get('password'),$salt),
                        'salt' => $salt,
                        'name' => Input::get('name'),
                        'joined' => date('Y-m-d H:i:s'),
                        'grup' => 1
                        ));
     Sessions::flash('home','You Have Been Registered You Can Now Login');
  Redirect::to('index.php');
  }
 
  catch(Exception $e)
  {
    die($e->getMessage());
  }
  
  }
  else
  {
    //print_r($validation->errors());
    foreach($validation->errors() as $error)
    {
      echo $error . "<br>";
    }
  }
}
}
?>
<form action="" method="POST">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'))?>" autocomplete="off">
        
    </div>
    <br>
      <div class="password">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" value="<?php echo escape(Input::get('password'))?>" autocomplete="off">
        
    </div>
      <div class="password_again">
        <label for="password_again">Confirm Password</label>
        <input type="password" name="password_again" id="password_again" value="<?php echo escape(Input::get('password_again'))?>" autocomplete="off">
        
    </div>
      <div class="name">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo escape(Input::get('name'))?>" autocomplete="off">
        
    </div>
      <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
      <input type="submit" value="REGISTER">
</form>
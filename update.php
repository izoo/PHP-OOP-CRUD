<?php
//update user's profile
require_once('core/init.php');
$user = new user();
if(!$user->isLoggedIn())
{
  Redirect::to('index.php');  
}
if(Input::exists())
{
  if(Token::check(Input::get('token')))
  {
    $validate = new Validate();
    $validation = $validate->check($_POST,array(
      'name' =>array(
        'required' => true,
        'min' =>2,
        'max' => 50
      )
    ));
    if($validation->passed())
    {
      //Update
      try
      {
        $user->update(array(
                           'name' => Input::get('name') 
                            ));
        Sessions::flash('home','Your Details Have Been Successfully Updated');
        Redirect::to('index.php');
      }
      catch(Exception $e)
      {
        die($e->getMessage());
      }
    }
    
    else
    {
      foreach($validation->errors() as $error)
      {
        echo $error  .  '<br>';
      }
    }
  }
}
?>
<form action="" method="POST">
  
    <div class="field">
        <label for="name">
            Name
        </label>
        <input type="text" name="name" value="<?php echo escape($user->data()->name) ?>">
    </div>
    <input type="submit" value="UPDATE">
    <input type="hidden" name="token" value="<?php echo Token::generate()?>">
</form> 
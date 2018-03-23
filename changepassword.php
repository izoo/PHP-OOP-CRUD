<?php
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
                'password_current' => array(
                    'required'=>true,
                    'min' =>6
                ),
                'password_new' => array(
                    'required' => true,
                    'min' => 6,
                    
                ),
                'confirm_password' =>array(
                   'required' => true,
                   'min' => 6,
                   'matches' => 'password_new'
                )
            ));
            if($validation->passed())
            {
                if(Hash::make(Input::get('password_current'),$user->data()->salt) !== $user->data()->password)
                {
                    echo 'Your Current Password is Wrong';
                }
                else
                {
                 $salt = Hash::salt(32);
                 $user->update(array(
                    'password' => Hash::make(Input::get('password_new'),$salt),
                    'salt' => $salt
                 ));
                 Sessions::flash("home","Your Session Has Been Successfully Changed!");
                 Redirect::to('index.php');
                }
            }
            else
            {
                foreach($validation->errors() as $error)
                {
                    echo $error . '<br>';
                }
            }
        }
    }

?>
<form action="" method="POST">
    <div class="username">
        <label for="password_current">
            Current Password
        </label>
       
        <input type="password" name="password_current" id="password_current" autocomplete="off">
        <br>
    </div>
    <div class="password">
        <label for="password_new">
          New  Password
        </label>
        <input type="password" name="password_new" id="password_new" autocomplete="off">
    </div>
    <br>
    <div class="field">
        <label for="confirm_password">
           Confirm New Password
        </label>
         <input type="password" name="confirm_password" id="remember">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
    <input type="submit" name="sub" value="CHANGE PASSWORD">
</form>
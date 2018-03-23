<?php
require_once('core/init.php');
if(Input::exists())
{
    if(Token::check(Input::get('token')))
       {
        $validate= new Validate();
        $validation = $validate->check($_POST,array(
                                             'username'=> array('required' => true),
                                             'password' =>array('required' => true),
                                              )
                                       );
        if($validation->passed())
        {
            //log user in
            $user = new User();
            $remember = (Input::get('remember')=='on') ? true : false;
            $login = $user->login(Input::get('username'),Input::get('password'),$remember);
            if($login)
            {
                Redirect::to('index.php');
            }
            else
            {
                echo '<p> Sorry Logging in Failed.</p>';
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
        <label for="username">
            Username
        </label>
        <br>
        <input type="text" name="username" id="username" autocomplete="off">
        <br>
    </div>
    <div class="password">
        <label for="password">
            Password
        </label>
        <input type="password" name="password" id="password" autocomplete="off">
    </div>
    <br>
    <div class="field">
        <label for="remember">
            <input type="checkbox" name="remember" id="remember">Remember Me
        </label>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
    <input type="submit" name="sub" value="LOGIN">
</form>
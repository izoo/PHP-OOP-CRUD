
<?php
//Included On Every Page To Be Used
//Allow Autoloading of Classes Without Need To require all classes
//Initialization File To Include On Each Page
//Defines this like Sessions and config files 
session_start();
//Global Variable
//an array of Different Config Settings,names of cookies
$GLOBALS['config'] = array(
    'mysql' =>array(
                    'host'=>'127.0.0.1',
                    'username'=>'root',
                    'password'=>'',
                    'db'=>'Alex'
                    ),
    'remember' =>array(
                       'cookie_name'=>'hash',
                       'cookie_expiry' =>604800
                       ),
    'session' =>array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);
spl_autoload_register(function($class)
                      {
                        require_once('classes/' . $class . '.php');
                        
                      });
require_once('functions/sanitize.php');
if(Cookie::exists(Config::get('remember/cookie_name')) && !Sessions::exists(Config::get('session/session_name')))
{
    $hash = Cookie::get(Config::get('remember/cookie_name'));
   $hashCheck = DB::getInstance()->get('users_session',array('hash','=',$hash));
   if($hashCheck->count())
   {
    $user = new user($hashCheck->first()->user_id);
    $user->login();
   }
}
?>
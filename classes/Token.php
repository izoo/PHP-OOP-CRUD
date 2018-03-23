<?php
//Entails Crosssite Request Forgery Protection
//Check if a token has been set on a form and it matches the current user 
class Token
{
    public static function generate()
    {
        return Sessions::put(Config::get('session/token_name'),md5(uniqid()));
    }
    public static function check($token)
    {
        $tokenName = Config::get('session/token_name');
        if(Sessions::exists($tokenName) && $token === Sessions::get($tokenName))
        {
            Sessions::delete($tokenName);
            return true;
        }
        return false;
    }
}
?>

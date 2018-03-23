
<?php
//entails database configurations
class Config
{
    public static function get($path=null)
    {
        if($path) 
        {
            $config = $GLOBALS['config'];
            $path = explode('/',$path);
            //print_r($path);
            foreach($path as $bit)
            {
                if(isset($config[$bit]))
                {
                    //echo 'SET';
                    $config=$config[$bit];
                }
            }
            return $config;
        }
        return false;
    }
}
?>
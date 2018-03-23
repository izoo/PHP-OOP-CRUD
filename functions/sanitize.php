
<?php
//Basically Sanitize Data,so we can output Data
//Protect Output From The Database
function escape($string)
{
    return htmlentities($string,ENT_QUOTES,'UTF-8');
}
?>
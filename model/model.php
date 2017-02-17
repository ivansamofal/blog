<?
include_once('config.php');

function template ($fileName, $vars = array()) 
{
    foreach ($vars as $key => $value)
    {
     $$key = $value;   
    }
    ob_start();
    include $fileName;
    return ob_get_clean();
        
}

//for index and sidebar


<?php

namespace LaRouxOf;

# larouxof.ph/api/Page/Welcome/getcontent
# larouxof.ph/api/Page/Ordering/getcontent
# larouxof.ph/api/Gallery/Bags/getItems/0/10
# larouxof.ph/api/Gallery/Shoes/getItems/20/10
# larouxof.ph/api/Item/Bags/bag-1/getItem
# larouxof.ph/api/Item/Bags/bag-3/getItem
# larouxof.ph/api/Item/Bags/bag-3/getImage/0
# larouxof.ph/api/Item/Bags/bag-3/getImage/3
# larouxof.ph/api/Item/Bags/bag-3/getNumOfImage
# larouxof.ph/api/Item/Bags/bag-3/getPrice
# larouxof.ph/api/Item/Bags/bag-3/getId
# larouxof.ph/api/ItemId/085472/getItem
# larouxof.ph/api/ItemId/085472/getImage/0
# larouxof.ph/api/ItemId/085472/getImage/3
# larouxof.ph/api/ItemId/085472/getNumOfImage
# larouxof.ph/api/ItemId/085472/getPrice

// We do not want anything to be sent to the client except a valid JSON response so buffer all output.
ob_start("ob_gzhandler");

// Enable autoloading of classes.
function my_autoloader($class) {
    include 'classes/' . $class . '.php';
}
spl_autoload_register('my_autoloader');

$call = $_SERVER['REQUEST_URI'];

try
{
    // Split the URI into seperate path items and check that the call is really an API call.
    if(($path = Functions::splitCall($call, 'api')) == null) throw new Exception("wrong formatted request URI");
    
    // Execute the real API call.
    $response = Functions::executeCall(Database::connect(), $path);
    
    // If the call returns an object, make sure it is serializable.
    if(is_object($response) && !($response instanceof JsonSerializable)) throw new Exception("object does not implement `JsonSerializable`");
    
    // Combine the response with status fields and actually serialize the whole respons.
    $json_response = json_encode(array('call' => $call, 'status' => 1, 'response' => $response));
    ob_clean();
}
catch(Exception $e)
{
    // Somewhere along the line an exception happened, construct a fail status and serialize.
    $json_response = json_encode(array('call' => $call, 'status' => 0, 'error' => $e->getMessage()));
    ob_clean();
}
finally
{
    // Clean the buffer and issue the response (success or error) to the client.
    ob_clean();
    echo $json_response;
    ob_end_flush();
}

?>
<?php

# larouxof.ph/api/Page/Welcome/getcontent
# larouxof.ph/api/Page/Ordering/getcontent
# larouxof.ph/api/Galary/Bags/getItems/0/10
# larouxof.ph/api/Galary/Shoes/getItems/20/10
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

// Move to own class file (wrapping in a abstract/static class make autoloading possible).
abstract class Functions
{
    final function splitCall(string $call, string $module = ""): ?array
    {
        $path = explode('/', $call);
        $path = array_slice($path, 1);
        if($module != "")
        {
            if($path[0] == $module)
                $path = array_slice($path, 1);
            else
                return null;
        }
        return $path;
    }
}

// We do not want anything to be sent to the client except a valid JSON response so buffer all output.
ob_start();

// Enable autoloading of classes.
function my_autoloader($class) {
    include 'classes/' . $class . '.php';
}
spl_autoload_register('my_autoloader');

function execute_call(array $path)
{
    try
    {
        // First item in path is the main class name.
        $class = $path[0];
        // Name of the method of the main class needed to inizialize the class.
        $method = 'load' . $class;
        // Check if main class exists.
        if(!class_exists($class)) throw new Exception("requested class `" . $class . "` does not exists.");
        $reflect = new ReflectionClass($class);
        // Check if method exists
        if(!$reflect->hasMethod($method)) throw new Exception("requested class does not have a method `" . $method . "`.");
        $reflect_method = $reflect->getMethod($method);
        // Make sure the method is static, as we do not have an initialized object yet.
        if(!$reflect_method->isStatic()) throw new Exception($class . "::" . $method . " is not a static method.");
        $n_param = $reflect_method->getNumberOfRequiredParameters();
        // The next $n_param are needed to initialize the main class (only the number of required parameters will be passed, any other parameters will get there default value).
        $args = array_slice($path, 1, $n_param);
        if(count($args) < $n_param) throw new Exception($class . "::" . $method . " requires at least " . $n_obj_param . " arguments, only " . count($args) . " are given.");
        // Here we really call the load method of the main class with the correct number of arguments.
        $obj = $reflect_method->invokeArgs(null, $args);
        
        // Name of the requested method on the returned object.
        $obj_method = $path[$n_param + 1];
        // All other arguments are passed to the method.
        $obj_method_args = array_slice($path, $n_param + 2);
    
        $obj_reflect = new ReflectionClass($obj);
        // Check in the requested method exists on the returned object.
        if(!$obj_reflect->hasMethod($obj_method)) throw new Exception("method `" . $obj_method . "` does not exist on object `" . get_class($obj) . "`.");
        $obj_reflect_method = $obj_reflect->getMethod($obj_method);
        // Make sure the method is public, private and restricted methods are not allowed to be exposed.
        if(!$obj_reflect_method->isPublic()) throw new Exception("method `" . $obj_method . "` of object `" . get_class($obj) . "` is not a public method.");
        // Count the number of required parameters needed for the requested method.
        $n_obj_param = $obj_reflect_method->getNumberOfRequiredParameters();
        if(count($obj_method_args) < $n_obj_param) throw new Exception(get_class($obj) . "::" . $obj_method . " requires at least " . $n_obj_param . " arguments.");
        // Finally make the call the the reqested method and return the answer.
        return $obj_reflect_method->invokeArgs($obj, $obj_method_args);
    }
    catch(ReflectionException $e)
    {
        throw new Exception("API error: " . $e->message);
    }
    
}

$call = $_SERVER['REQUEST_URI'];

try
{
    // Split the URI into seperate path items and check that the call is really an API call.
    if(($path = Functions::splitCall($call, 'api')) == null) throw new Exception("wrong formatted request URI");
    
    // Execute the real API call.
    $response = execute_call($path);
    
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
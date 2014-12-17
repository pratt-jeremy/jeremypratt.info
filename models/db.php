<?php
/**
 * These first lines decide which settings file to load based on an environment variable.
 * The Stage and Production settings files are not checked in so that the connection strings are not
 * available to other users on github.
 **/
if (isset ($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] == 'production')
{
    // loads the connection strings for the production server.
    require dirname(__FILE__) . '/../settings-prod.php';
}
elseif (isset ($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] == 'stage')
{
    // loads the connection strings for the stage server.
    require dirname(__FILE__) . '/../settings-stage.php';
}
else 
{
    // loads the connection strings for the local/test server.
    require dirname(__FILE__) . '/../settings-test.php';
}


/// Executes an arbitrary database query.
/// Doesn't return anything (since we aren't sure the query will return anything).
/// $query - the sql statement to run.
/// $params (array) - the parameters to bind to the query.
function DbExecute($query, $params = null)
{
    global $db;

    try 
    {
        $statement = $db->prepare($query);
        
        if (is_array($params))
        {
            foreach ($params as $key => $value)
            {
                $statement->bindValue($key, $value);
            }
        }
        
        $statement->Execute();
    }
    catch (Exception $e)
    {
        echo "Database exception, try again later.";
        error_log($e);
        exit();
    }
}


/// Runs an INSERT statement
/// Returns the ID of the inserted item.
/// $query - the sql statement to run.
/// $params (array) - the parameters to bind to the query.
function DbInsert($query, $params = null)
{
    global $db;
    $return = false;
    
    try
    {
        $statement = $db->prepare($query);
        
        if (is_array($params))
        {
            foreach ($params as $key => $value)
            {
                $statement->bindValue($key, $value);
            }
        }
        
        $statement->Execute();
        $return = $db->lastInsertId();
    }
    catch (Exception $e)
    {
        echo "Database insert exception, please try again later.";
        error_log($e);
        exit();
    }
    
    return $return;
}


/// Runs a SELECT statement
/// Returns an array containing the matching rows.
/// $query - the sql statement to run.
/// $params (array) - the parameters to bind to the query.
function DbSelect($query, $params = null)
{
    global $db;
    $return = array();

    try 
    {
        $statement = $db->prepare($query);
        
        if (is_array($params))
        {
            foreach ($params as $key => $value)
            {
                $statement->bindValue($key, $value);
            }
        }
        
        $statement->Execute();
        
        while ($row = $statement->fetch())
        {
            $return[] = $row;
        }
    }
    catch (Exception $e)
    {
        echo "Database exception, try again later.";
        error_log($e);
        exit();
    }
    
    return $return;
}

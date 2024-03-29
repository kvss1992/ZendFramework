<?php

return array(
'db' => array(
'driver' => 'Pdo',
 'dsn' => 'mysql:dbname=zf2tutorial;host=localhost',
'driver_options' => array(
PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
),
),
'service_manager' => array(
'factories' => array(
'Zend\Db\Adapter\Adapter'
=> 'Zend\Db\Adapter\AdapterServiceFactory',
),
/* Moved to Auth module to allow to be replaced by Doctrine or other.
// added for Authentication and Authorization. Without this each time we have to create a new instance.
// This code should be moved to a module to allow Doctrine to overwrite it
'aliases' => array( // !!! aliases not alias
'Zend\Authentication\AuthenticationService' => 'my_auth_service',
),
'invokables' => array(
'my_auth_service' => 'Zend\Authentication\AuthenticationService',
),
*/
),

/*'static_salt' => 'aFGQ475SDsdfsaf2342', // was moved from module.config.php here to allow all modules to use it*/
);
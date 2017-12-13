<?php
namespace Fuel\Migrations;

class Roles
{
		
    function up()
    {	
    	try
    	{
	        \DBUtil::create_table(
	    		'roles',
	    		array(
	    		    'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
	    		    'name' => array('type' => 'text'),
	    		),
	    		array('id'), false, 'InnoDB', 'utf8_general_ci'
			);
    	}
    	catch(\Database_Exception $e)
		{
		   echo 'songs ya creada'; 
		}
    }

    function down()
    {
       \DBUtil::drop_table('roles');
    }

}
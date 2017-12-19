<?php
namespace Fuel\Migrations;

class Users
{
		
    function up()
    {	
    	try
    	{
	        \DBUtil::create_table(
	    		'users',
	    		array(
	    		    'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
	    		    'name' => array('type' => 'text'),
                    'email' => array('type' => 'text'),
	    		    'password' => array('type' => 'text'),
	    		    'id_role' => array('type' => 'int'),
	    		),
	    		array('id'), false, 'InnoDB', 'utf8_general_ci',
	    		array(
                    array(
                        'constraint' => 'foreingKeyUsersToRoles',
                        'key' => 'id_role',
                        'reference' => array(
                            'table' => 'roles',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
                        'on_delete' => 'CASCADE'
                    )
                )
			);
    	}
    	catch(\Database_Exception $e)
		{
		   echo 'users ya creada'; 
		}
    }

    function down()
    {
       \DBUtil::drop_table('users');
    }

}
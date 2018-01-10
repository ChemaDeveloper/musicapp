<?php
namespace Fuel\Migrations;

class News
{
		
    function up()
    {	
    	try
    	{
	        \DBUtil::create_table(
	    		'news',
	    		array(
	    		    'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
	    		    'description' => array('type' => 'text'),
	    		    'id_user' => array('type' => 'int'),
	    		),
	    		array('id'), false, 'InnoDB', 'utf8_general_ci',
	    		array(
                    array(
                        'constraint' => 'foreingKeyNewsToUsers',
                        'key' => 'id_user',
                        'reference' => array(
                            'table' => 'users',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
                        'on_delete' => 'RESTRICT'
                    )
                )
			);
    	}
    	catch(\Database_Exception $e)
		{
		   echo 'ya creada'; 
		}
    }

    function down()
    {
       \DBUtil::drop_table('news');
    }

}
<?php 

class Model_Users extends Orm\Model
{
    protected static $_table_name = 'users';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
        'name' => array(
            'data_type' => 'text'   
        ),
        'password' => array(
            'data_type' => 'text'   
        ),
        'email' => array(
            'data_type' => 'text'   
        ),
        'id_role' => array(
            'data_type' => 'int'   
        )
    );
    protected static $_has_many = array(
        'list' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Lists',
            'key_to' => 'id_user',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
        'new' => array(
            'key_from' => 'id',
            'model_to' => 'Model_News',
            'key_to' => 'id_user',
            'cascade_save' => true,
            'cascade_delete' => false,
        )

    );
    protected static $_belongs_to = array(
        'role' => array(
            'key_from' => 'id_role',
            'model_to' => 'Model_Roles',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );
    protected static $_many_many = array(
        'follower' => array(
            'key_from' => 'id',
            'key_through_from' => 'id_follower', // column 1 from the table in between, 
            'table_through' => 'users_users', // both models plural without prefix in alphabetical order
            'key_through_to' => 'id_followed', // column 2 from the table in between,
            'model_to' => 'Model_Users',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'followed' => array(
            'key_from' => 'id',
            'key_through_from' => 'id_follower', // column 1 from the table in between,
            'table_through' => 'users_users', // both models plural without prefix in alphabetical order
            'key_through_to' => 'id_followed', // column 2 from the table in between, 
            'model_to' => 'Model_Users',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
}
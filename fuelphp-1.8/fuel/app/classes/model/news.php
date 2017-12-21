<?php 

class Model_Songs extends Orm\Model
{
    protected static $_table_name = 'news';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
        'description' => array(
            'data_type' => 'text'   
        ),
        'id_user' => array(
            'data_type' => 'int'   
        )
    );
    protected static $_belongs_to = array(
        'user' => array(
            'key_from' => 'id_user',
            'model_to' => 'Model_Users',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
}
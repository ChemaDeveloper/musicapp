<?php
class Model_Lists_songs extends Orm\Model
{
    protected static $_table_name = 'users_users';
    protected static $_primary_key = array('id_follower', 'id_followed');
    protected static $_properties = array(
        'id_followed' => array(
            'data_type' => 'int'   
        ),
        'id_followed' => array(
            'data_type' => 'int'   
        )
    );
    
}
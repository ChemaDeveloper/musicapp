<?php
class Model_Lists_have_songs extends Orm\Model
{
    protected static $_table_name = 'lists_have_songs';
    protected static $_primary_key = array('id_list', 'id_song');
    protected static $_properties = array(
        'id_list',
        'id_song' => array(
            'data_type' => 'int'   
        )
    );
    protected static $_many_many = array(
	    'songs' => array(
	        'key_from' => 'id',
	        'key_through_from' => 'id_song', // column 1 from the table in between, should match a posts.id
	        'table_through' => 'lists_have_songs', // both models plural without prefix in alphabetical order
	        'key_through_to' => 'id_list', // column 2 from the table in between, should match a users.id
	        'model_to' => 'Model_Lists',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	    )
	);
	protected static $_many_many = array(
	    'lists' => array(
	        'key_from' => 'id',
	        'key_through_from' => 'id_list', // column 1 from the table in between, should match a posts.id
	        'table_through' => 'lists_have_songs', // both models plural without prefix in alphabetical order
	        'key_through_to' => 'id_song', // column 2 from the table in between, should match a users.id
	        'model_to' => 'Model_Songs',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	    )
	);
}
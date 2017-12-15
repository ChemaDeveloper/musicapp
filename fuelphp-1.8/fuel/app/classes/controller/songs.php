<?php 
class Controller_Songs extends Controller_Base
{
	public function post_create()
    {
        $auth = self::authenticate();
        if($auth == true)
        {
            try {
                if ( ! isset($_POST['title']) && ! isset($_POST['url'])) 
                {
                    $json = $this->response(array(
                        'code' => 400,
                        'message' => 'parametro incorrecto'
                    ));
                    return $json;
                }
                
                $input = $_POST;
                $title = $input['title'];
                $url = $input['url'];
                $song = new Model_Songs();
                $song->title = $title;
                $song->url = $url;
                $song->save();
                $json = $this->response(array(
                    'code' => 201,
                    'message' => 'Canción creada',
                ));
                return $json;
            } 
            catch (Exception $e) 
            {
                $json = $this->response(array(
                    'code' => 500,
                    'message' => 'error interno del servidor',
                ));
                return $json;
            }
        }
        else
        {
        	$json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuario no autenticado',
                ));
                return $json;
        }
        
    }
    public function get_songs()
    {   
        $auth = self::authenticate();
        if($auth == true)
        {
            try {
                
                
                $songs = Model_Songs::find('all');
	            $indexedSongs = Arr::reindex($songs);
	            foreach ($indexedSongs as $key => $song) {
	                $title[] = $song->title;
	                $url[] = $song->url;
	                $id[] = $song->id;
	            }
                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Canciones en la app',
                    'title' => $title,
                    'url' => $url,
                    'id' => $id,
                ));
                return $json;
            } 
            catch (Exception $e) 
            {
                $json = $this->response(array(
                    'code' => 500,
                    'message' => 'error interno del servidor',
                ));
                return $json;
            }
        }
        else
        {
        	$json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuario no autenticado',
                ));
                return $json;
        }
        
    }
}
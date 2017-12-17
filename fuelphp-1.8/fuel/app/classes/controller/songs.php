<?php 
class Controller_Songs extends Controller_Base
{
	public function post_create()
    {
        $auth = self::authenticate();
        if($auth == true)
        {
            try {
                if ( ! isset($_POST['title']) && ! isset($_POST['artist']) && ! isset($_POST['url'])) 
                {
                    $json = $this->response(array(
                        'code' => 400,
                        'message' => 'parametro incorrecto',
                        'data' => null
                    ));
                    return $json;
                }
                
                $input = $_POST;
                $title = $input['title'];
                $artist = $input['artist'];
                $url = $input['url'];
                $songUrl = Model_Songs::find('all', 
                                 ['where' => 
                                 ['url' => $url]]);
	            if (!empty($songUrl)) {
	                $json = $this->response(array(
	                    'code' => 400,
	                    'message' => 'url ya usada',
	                    'data' => null,
	                ));
	                return $json;
	            }
	            $decodedToken = self::decodeToken();
                if($decodedToken->role == 1)
                {
	                $song = new Model_Songs();
	                $song->title = $title;
	                $song->artist = $artist;
	                $song->url = $url;
	                $song->save();
	                $json = $this->response(array(
	                    'code' => 201,
	                    'message' => 'Canción creada',
	                    'data' => null
	                ));
	                return $json;
                }
                else
                {
                    $json = $this->response(array(
                        'code' => 401,
                        'message' => 'No estas autorizado a crear canciones',
                        'data' => null
                    ));
                    return $json;
                }
            } 
            catch (Exception $e) 
            {
                $json = $this->response(array(
                    'code' => 500,
                    'message' => 'error interno del servidor',
                    'data' => null
                ));
                return $json;
            }
        }
        else
        {
        	$json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuario no autenticado',
                    'data' => null
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
	                $artist[] = $song->artist;
	                $url[] = $song->url;
	                $id[] = $song->id;
	            }
                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Canciones en la app',
                    'data' => ['title' => $title,
                    		   'artist' => $artist,
			                   'url' => $url,
			                   'id' => $id]
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
    public function post_update()
    {
        $input = $_POST;   
        $auth = self::authenticate();
        if($auth == true)
        {
            if ( ! isset($_POST['id']) ) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametros incorrectos',
                    'data' => null
                ));
                return $json;
            }

            $id = $input['id'];
            $updateSong = Model_Songs::find($id);
            
            if(!empty($updateSong))
            {
                $decodedToken = self::decodeToken();
                if($decodedToken->role == 1)
                {
                    if(isset($_POST['title']))
	            	{
	            		$title = $input['title'];
	            		$updateSong->title = $title;
	            	}
	            	if(isset($_POST['artist']))
	            	{
	            		$artist = $input['artist'];
	            		$updateSong->artist = $artist;
	            	}	
	            	if(isset($_POST['url']))
	            	{
	            		$url = $input['url'];
	            		$songUrl = Model_Songs::find('all', 
	                                 ['where' => 
	                                 ['url' => $url]]);
			            if (!empty($songUrl)) {
			                $json = $this->response(array(
			                    'code' => 400,
			                    'message' => 'url ya usada',
			                    'data' => null,
			                ));
			                return $json;
			            }
			            else
			            {
			            	$updateSong->url = $url;
			            }	
	            		
	            	}
	            	$updateSong->save();
                    $json = $this->response(array(
                    'code' => 200,
                    'message' => 'canción actualizada',
                    'data' => null
                    ));
                    return $json;
                }
                else
                {
                    $json = $this->response(array(
                        'code' => 401,
                        'message' => 'No estas autorizado a cambiar esa canción',
                        'data' => null
                    ));
                    return $json;
                }
            }
            else
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'canción no encontrada',
                    'data' => null
                ));
                return $json;
            }
        }
        else
        {
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuario no autenticado',
                    'data' => null
            ));
            return $json;
        }
    }
    public function post_delete()
    {   
        $input = $_POST;   
        $auth = self::authenticate();
        if($auth == true)
        {
            if ( ! isset($_POST['id'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame id',
                    'data' => null
                ));
                return $json;
            }
            $decodedToken = self::decodeToken();
            if($decodedToken->role == 1)
            {
	            $song = Model_Songs::find($_POST['id']);
	            if(!empty($song))
	            {
	                $songName = $song->title;
	                $song->delete();
	            }
	            $json = $this->response(array(
	                'code' => 200,
	                'message' => 'lista borrada',
	                'data' => ['name' => $songName]
	            ));
	            return $json;
	        }
            else
            {
                $json = $this->response(array(
                    'code' => 401,
                    'message' => 'No estas autorizado a eliminar canciones',
                    'data' => null
                ));
                return $json;
            }
        }
        else
        {
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
                    'data' => null
            ));
            return $json;
        }
    }
}
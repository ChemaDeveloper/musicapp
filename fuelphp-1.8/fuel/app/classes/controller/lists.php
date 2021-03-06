<?php 
class Controller_Lists extends Controller_Base
{
	public function post_create()
    {
        $auth = self::authenticate();
        if($auth == true)
        {
            try {
                if ( ! isset($_POST['name'])) 
                {
                    $json = $this->response(array(
                        'code' => 400,
                        'message' => 'parametro incorrecto',
                        'data' => null
                    ));
                    return $json;
                }
                
                $input = $_POST;
                $name = $input['name'];
                $decodedToken = self::decodeToken();

                $list = new Model_Lists();
                $list->title = $name;
                $list->user = Model_Users::find($decodedToken->id);
                $list->save();
                $json = $this->response(array(
                    'code' => 201,
                    'message' => 'lista creada',
                    'data' => null
                ));
                return $json;
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
            $list = Model_Lists::find($_POST['id']);
            if(!empty($list))
            {
                $listName = $list->title;
                $list->delete();
            }
            $json = $this->response(array(
                'code' => 200,
                'message' => 'lista borrada',
                'data' => ['name' => $listName]
            ));
            return $json;
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
    public function post_update()
    {
        $input = $_POST;   
        $auth = self::authenticate();
        if($auth == true)
        {
            if ( ! isset($_POST['id']) || ! isset($_POST['name']) ) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametros incorrectos',
                    'data' => null
                ));
                return $json;
            }
            $id = $_POST['id'];
            $updateList = Model_Lists::find($id);
            $title = $_POST['name'];
            if(!empty($updateList))
            {


                $decodedToken = self::decodeToken();
                if($decodedToken->id == $updateList->id_user)
                {
                    $updateList->title = $title;
                    $updateList->save();
                    $json = $this->response(array(
                    'code' => 200,
                    'message' => 'lista actualizada',
                    'data' => null
                    ));
                    return $json;
                }
                else
                {
                    $json = $this->response(array(
                        'code' => 401,
                        'message' => 'No estas autorizado a cambiar esa lista',
                        'data' => null
                    ));
                    return $json;
                }
            }
            else
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'lista no encontrada',
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
    public function get_private_lists()
    {   
        $auth = self::authenticate();
        if($auth == true)
        {
            $decodedToken = self::decodeToken();
            $lists = Model_Lists::find('all', 
                                 ['where' => 
                                 ['id_user' => $decodedToken->id]]);
            
            if($lists != null)
            {
               $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Listas privadas',
                    'data' => ['lists' => $lists]
                )); 
            }         
            else
            {
               $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Listas privadas vacias',
                    'data' => null
                ));  
            }
            return $json;
        }else{
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
                    'data' => null
            ));
            return $json;
        }
        
    }
    public function post_add_song()
    {
        $auth = self::authenticate();
        if($auth == true)
        {
            try {
                if ( ! isset($_POST['id_song']) || ! isset($_POST['id_list'])) 
                {
                    $json = $this->response(array(
                        'code' => 400,
                        'message' => 'parametro incorrecto',
                        'data' => null
                    ));
                    return $json;
                }
                
                $input = $_POST;
                $id_song = $input['id_song'];
                $id_list = $input['id_list'];
                $decodedToken = self::decodeToken();

                $list = Model_Lists::find($id_list);
                if($list->id_user == $decodedToken->id)
                {
                    $list->song[] = Model_Songs::find($id_song);
                    $list->save();
                    $json = $this->response(array(
                        'code' => 200,
                        'message' => 'Cancion añadida',
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
        
    }

}
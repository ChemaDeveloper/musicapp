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
                        'message' => 'parametro incorrecto'
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
                $indexedLists = Arr::reindex($lists);
                foreach ($indexedLists as $key => $list) {
                    $title[] = $list->title;
                    $id[] = $list->id;
                }
               $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Listas privadas',
                    'title' => $title,
                )); 
            }         
            else
            {
               $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Listas privadas vacias',
                ));  
            }
            return $json;
        }else{
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
            ));
            return $json;
        }
        
    }
}
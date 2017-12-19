<?php 
class Controller_Users extends Controller_Base
{
    
    public function post_create()
    {
        try {
           if ( ! isset($_POST['name']) && ! isset($_POST['password']) && ! isset($_POST['role']) && ! isset($_POST['email'])) 
           {
               $json = $this->response(array(
                   'code' => 400,
                   'message' => 'parametro incorrecto',
                   'data' => null,
               ));
               return $json;
           }
            
            $input = $_POST;
            $name = $input['name'];
            $password = $input['password'];
            $admin = $input['role'];
            $email = $input['email'];
            if($admin == 'true')
            {
                $role = 1;
            }
            else
            {
                $role = 2;
            }
            $userName = Model_Users::find('all', 
                                 ['where' => 
                                 ['name' => $name]]);
            if (!empty($userName)) {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Nombre de usuario ya escogido',
                    'data' => null,
                ));
                return $json;
            }
            $userEmail = Model_Users::find('all', 
                                 ['where' => 
                                 ['email' => $email]]);
            if (!empty($userEmail)) {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Email ya usado',
                    'data' => null,
                ));
                return $json;
            }
            $user = new Model_Users();
            $user->name = $name;
            $user->password = $password;
            $user->email = $email;
            $user->role = Model_Roles::find($role);
            $user->save();
            $json = $this->response(array(
                'code' => 201,
                'message' => 'usuario creado',
                'data' => ['name' => $input['name']],
            ));
            return $json;
       } 
       catch (Exception $e) 
       {
           $json = $this->response(array(
               'code' => 500,
               'message' => 'error interno del servidor',
               'data' => null,
           ));
           return $json;
       }
        
    }
    public function get_users()
    {   
        $auth = self::authenticate();
        if($auth == true)
        {
            $users = Model_Users::find('all', ['select' => ['name']]);
            $indexedUsers = Arr::reindex($users);
            foreach ($indexedUsers as $key => $user) {
                $name[] = $user->name;
                $id[] = $user->id;
            }
            $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Usuarios de la app',
                    'data' => ['name' => $name,
                                'id' => $id,]
            ));
            return $json;
        }else{
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
                    'data' => null,
            ));
            return $json;
        }
        
    }
    public function get_login()
    {
        if ( ! isset($_GET['name']) && ! isset($_GET['password']) ) 
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'parametro incorrecto',
                'data' => null,
            ));
            return $json;
        }
        
        $input = $_GET;   
        $name = $input['name'];
        $password = $input['password'];
        $user = Model_Users::find('all', 
                                 ['where' => 
                                 ['name' => $name, 
                                  'password' => $password]]);

        if($user != null)
        {
            foreach ($user as $key => $value) {
                $id = $value->id;
                $id_role = $value->id_role;
                $email = $value->email;
            }
            
            $encodedToken = self::encodeToken($name, $password, $id, $email, $id_role);
            
            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario logeado',
                'data' => ['token' => $encodedToken],
            ));
            return $json;
        }else{
            $json = $this->response(array(
                'code' => 401,
                'message' => 'Usuario o contraseña incorrectos',
                'data' => null,
            ));
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
                    'data' => null,
                ));
                return $json;
            }
            $user = Model_Users::find($_POST['id']);
            if(!empty($user))
            {
                $user->delete();
            }
            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario borrado',
                'data' => null
            ));
            return $json;
        }
        else
        {
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
                    'data' => null,
            ));
            return $json;
        }
    }
    public function get_user_data()
    {
        $input = $_GET;   
        $auth = self::authenticate();
        if($auth == true)
        { 
            if ( ! isset($_GET['id'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame id',
                    'data' => null,
                ));
                return $json;
            }
            $user = Model_Users::find($_GET['id']);
            $name = $user['name'];
            $password = $user['password'];
            $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Datos del usuario',
                    'data' => ['name' => $name,
                               'password' => $password],
                    
            ));
            return $json;
        }
        else
        {
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
                    'data' => null,
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
                    'message' => 'parametro incorrecto, se necesitan todos los parametros',
                    'data' => null,
                ));
                return $json;
            }
            $id = $_POST['id'];
            $decodedToken = self::decodeToken();
            $updateUser = Model_Users::find($id);
            if(!empty($updateUser) && $decodedToken->role == 1){
                if (isset($_POST['name'])) 
                {
                    $name = $input['name'];
                    $updateUser->name = $name;
                }
                else
                {
                    $name = $decodedToken->name;
                }
                if (isset($_POST['password'])) 
                {
                    $password = $input['password'];
                    $updateUser->password = $password;
                }
                else
                {
                    $password = $decodedToken->password;
                }
                $updateUser->save();
                
                if($decodedToken->id == $id)
                {
                    $encodedToken = self::encodeToken($name, $password, $id, $decodedToken->email, $decodedToken->role);
                    $json = $this->response(array(
                    'code' => 200,
                    'message' => 'usuario y token actualizado',
                    'data' => ['token' =>$encodedToken]
                    ));
                }
                else
                {
                    $json = $this->response(array(
                        'code' => 200,
                        'message' => 'usuario actualizado',
                        'data' => null,
                    ));
                    return $json;
                }
            }
            else
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'usuario no encontrado o no estas autorizado a actualizarlo',
                    'data' => null,
                ));
                return $json;
            }
        }
        else
        {
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
                    'data' => null,
            ));
            return $json;
        }
    }    
}

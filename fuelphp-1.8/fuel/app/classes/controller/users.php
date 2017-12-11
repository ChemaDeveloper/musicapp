<?php 
class Controller_Users extends Controller_Base
{
    
    public function post_create()
    {
        // try {
            if ( ! isset($_POST['name']) || ! isset($_POST['password']) || ! isset($_POST['role'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto'
                ));
                return $json;
            }
            
            $input = $_POST;
            $name = $input['name'];
            $password = $input['password'];
            $admin = $input['role'];
            if($admin == 'true')
            {
                $role = 1;
            }
            else
            {
                $role = 2;
            }

            $user = new Model_Users();
            $user->name = $name;
            $user->password = $password;
            $user->role = Model_Roles::find($role);
            $user->save();
            $json = $this->response(array(
                'code' => 201,
                'message' => 'usuario creado',
                'name' => $input['name'],
            ));
            return $json;
        // } 
        // catch (Exception $e) 
        // {
        //     $json = $this->response(array(
        //         'code' => 500,
        //         'message' => 'error interno del servidor',
        //     ));
        //     return $json;
        // }
        
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
                    'name' => $name,
                    'id' => $id,
            ));
            return $json;
        }else{
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
            ));
            return $json;
        }
        
    }
    public function get_login()
    {
        if ( ! isset($_GET['name']) || ! isset($_GET['password']) ) 
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'parametro incorrecto'
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
                $role = $value->id_role;
            }
            
            $encodedToken = self::encodeToken($name, $password, $id, $role);
            
            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario logeado',
                'token' => $encodedToken,
            ));
            return $json;
        }else{
            $json = $this->response(array(
                'code' => 401,
                'message' => 'Usuario o contraseña incorrectos'
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
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame id'
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
                'name' => $userName
            ));
            return $json;
        }
        else
        {
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
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
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame id'
                ));
                return $json;
            }
            $user = Model_Users::find($_GET['id']);
            $name = $user['name'];
            $password = $user['password'];
            $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Usuario actualizando',
                    'name' => $name,
                    'password' => $password,
            ));
            return $json;
        }
        else
        {
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
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
            if ( ! isset($_POST['id']) || ! isset($_POST['name']) || ! isset($_POST['password']) ) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame id'
                ));
                return $json;
            }
            $id = $_POST['id'];
            $updateUser = Model_Users::find($id);
            $name = $_POST['name'];
            $password = $_POST['password'];
            if(!empty($updateUser)){
                $updateUser->name = $name;
                $updateUser->password = $password;
                $updateUser->save();
                $decodedToken = self::decodeToken();
                if($decodedToken->id == $id)
                {
                    $encodedToken = self::encodeToken($name, $password, $id, $decodedToken->role);
                    $json = $this->response(array(
                    'code' => 200,
                    'message' => 'usuario y token actualizado',
                    'token' => $encodedToken
                    ));
                }
                else
                {
                    $json = $this->response(array(
                        'code' => 200,
                        'message' => 'usuario actualizado'
                    ));
                    return $json;
                }
            }
            else
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'usuario no encontrado'
                ));
                return $json;
            }
        }
        else
        {
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
            ));
            return $json;
        }
    }    
}
 <?php 
use \Firebase\JWT\JWT;
define('MY_KEY', 'tokens_key');
class Controller_Base extends Controller_Rest
{
    public function post_config(){
        $admin = Model_Users::find('all',
                                    ['where' => ['name' => 'admin']]);
        if(empty($admin))
        {
            $adminRole = new Model_Roles();
            $adminRole->name = "admin";
            $adminRole->save();
            $userRole = new Model_Roles();
            $userRole->name = "user";
            $userRole->save();
            $admin = new Model_Users();
            $admin->name = "admin";
            $admin->password = "1234";
            $admin->email = "admin@admin.es";
            $admin->role = Model_Roles::find(1);
            $admin->save();
            $json = $this->response(array(
                'code' => 201,
                'message' => 'Configuración terminada correctamente',
                'data' => $admin,
            ));
            return $json;
        }
        else
        {
            $json = $this->response(array(
                'code' => 401,
                'message' => 'Configuración ya implementada anteriormente',
                'data' => null,
            ));
            return $json;
        }
    }
	protected function encodeToken($name, $password, $id, $email, $id_role)
    {
        $token = array(
                "name" => $name,
                "password" => $password,
                "id" => $id,
                "email" => $email,
                "role" => $id_role
        );
        $encodedToken = JWT::encode($token, MY_KEY);
        return $encodedToken;
    }
    protected function decodeToken(){
        $header = apache_request_headers();
        $token = $header['Autorization'];
        if(!empty($token))
        {
            $decodedToken = JWT::decode($token, MY_KEY, array('HS256'));
            return $decodedToken;
        }      
    }
    protected function authenticate(){
        try {
               
            $header = apache_request_headers();
            $token = $header['Autorization'];
            if(!empty($token))
            {
                $decodedToken = JWT::decode($token, MY_KEY, array('HS256'));
                $query = Model_Users::find('all', 
                    ['where' => ['name' => $decodedToken->name, 
                                 'password' => $decodedToken->password, 
                                 'id_role' => $decodedToken->role,
                                 'email' => $decodedToken->email,
                                 'id' => $decodedToken->id]]);
                if($query != null)
                {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        } 
        catch (Exception $UnexpectedValueException)
        {
            return false;
        }
    }
    public function get_default_auth()
    {  
        $auth = self::authenticate();
        if($auth == true)
        {
            $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Usuario autenticado',
                    'data' => null
            ));
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
}
<?php
namespace App\Repositories\User;

use Auth, Exception;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\{ Support\Str, Http\Request };


class UserRepository extends BaseRepository
{

    /**
     * 
     * @param array $credentials
     * @return \Illuminate\Http\JsonResponse
    */
	public function login($credentials)
	{	        
        try{
            if (!auth()->attempt((array) $credentials)) {
                throw new Exception('The provided credentials do not match our records', 404);  
            }

            $user = User::whereEmail($credentials['email'])->first();
            $auth_token = $user->createToken('auth-token')->plainTextToken;

            return $this->sendResponse(['name' => $user->name, 'email' => $user->email, 'access_token' => $auth_token] , 'User login successfully');    

        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $e->getCode());       
        }
	}

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
    */
	public function create(Request $request)
	{
		 try {
            $request->merge([
                'password' => bcrypt($request->password), 
            ]);

            $user = User::create($request->all());
            $access_token = $user->createToken('auth-token')->plainTextToken;

            //$user->roles()->attach(2);

            return $this->sendResponse(['name' => $user->name, 'email' => $user->email, 'access_token' => $access_token] , 'User registered successfully'); 

        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $e->getCode());       
        }
	}

    /**
     * 
     * @return \Illuminate\Http\JsonResponse 
    */
    public function logout()
    {
        try {   
            auth()->user()->tokens()->delete();
            return $this->sendSuccess('User logout successfully');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $e->getCode());       
        }
    }

}
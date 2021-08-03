<?php
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Repositories\User\UserRepository;

class AuthController extends Controller
{
    
    /**
     * @var \App\Repositories\User\UserRepository
     */
    private $user;

    /**
     * @param \App\Repositories\User\UserRepository  $userrepo
     *
     */
    public function __construct(UserRepository $userrepo) {
        $this->user = $userrepo;
    }

    /**
     * Authenticate user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {   
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        return $this->user->login($credentials);   
    }

    /**
     * Register new user
     *
     * @param  \App\Http\Requests\RegisterRequest  $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
       return $this->user->create($request);   
    }

    /**
     * Logout user
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()
    {    
        return $this->user->logout();   
    }

}

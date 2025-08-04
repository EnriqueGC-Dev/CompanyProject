<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Companies;

use Exception;

class UserController extends BaseController
{
    //Registro de usuario
    public function signUp(Request $request)
    {
        $data = $request->all();

        $company = Companies::create([
            'company_name' => $data['company'],
            'company_active' => 1,
            'company_end_subscription' => date("Y-m-d 00:00:00", strtotime("+1 year +1 days"))

        ]);
        
        $companyID = Companies::where('company_name', $data['company'])->first();

        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => 2,
            'company_id' => $companyID['company_id']
        ]);
        
        return response()->json([
            'message' => 'Usuario Creado Correctamente',
            'status' => 'OK',
            'id' => $user->id
        ]);
    }

    //Inicio de sesión
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            return response()->json([
                'status' => 'OK',
                'server' => $_SERVER,
                'cookies' => $_COOKIE,
                'environment' => $_ENV
            ], 200);

        } else {
            return response()->json([
                'status' => 'ERROR'
            ], 401);
        }
    }

    // Cierre de sesión
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return response()->json([
            'status' => 'OK'
        ]);
    }

    //Obtener el objeto User como json
    public function user(Request $request)
    {
        $user = $request->user();

        if ($user instanceof User) {
            $json = array_merge(
                ['status' => 'OK'],
                $user->toArray(),
            );
        } else {
            $json = [
                'status' => 'ERROR',
                'server' => $_SERVER,
                'cookies' => $_COOKIE,
                'environment' => $_ENV
            ];
        }

        return response()->json($json);
    }
}
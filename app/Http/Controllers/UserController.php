<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

use App\Models\User;
use App\Models\Companies;

use Exception;

class UserController extends BaseController
{
    //Registro de usuario
    public function signUp(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users'
            ]);

            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = bcrypt('M4r1a.25');
            $user->save();

            // Enviar email de bienvenida
            Mail::to($user->email)->send(new WelcomeMail($user));

            return response()->json([
                'status' => 'OK',
                'user' => $user
            ], 201);
            
        } catch (Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    //Inicio de sesión
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Verificar que el email esté verificado
            if ($user->email_verified_at === null) {
                Auth::logout();
                return response()->json([
                    'status' => 'ERROR',
                    'message' => 'Debes verificar tu correo electrónico antes de iniciar sesión.'
                ], 403);
            }

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

    // Verificar email por id
    public function verifyEmail($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect('/')->with('status', 'Usuario no encontrado');
        }

        if ($user->email_verified_at === null) {
            $user->email_verified_at = now();
            $user->save();

            return redirect('/')->with('status', 'Email verificado correctamente');
        } else {
            return redirect('/')->with('status', 'El email ya estaba verificado');
        }
    }

    // Verificar email por id
    public function setPassword($id)
    {
        $pass = request(['password']);
        $user = User::find($id);

        if (!$user) {
            return redirect('/')->with('status', 'Usuario no encontrado');
        }

        $user->password = bcrypt($pass['password']);
        $user->first_log = true;
        $user->save();

        return response()->json([
                'status' => 'OK',
                'server' => $_SERVER,
                'cookies' => $_COOKIE,
                'environment' => $_ENV
            ], 200);

    }
}
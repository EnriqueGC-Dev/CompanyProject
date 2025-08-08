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
                'company' => 'required|string|max:255',
                'companyCIF' => 'required|string|max:9',
                'companyType' => 'required|integer|in:1,2,3',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users'
            ]);

            // Calcular la fecha de finalización de la suscripción
            $Date = date("Y/m/d");
            $Date = date('Y-m-d', strtotime($Date. ' + '. $validated['companyType'] .' years'));

            // Crear la empresa
            $company = new Companies();
            $company->company_CIF = $validated['companyCIF'];
            $company->company_name = $validated['company'];
            $company->company_end_subscription = $Date;
            $company->save();

            // Obtener el ID de la empresa recién creada
            $company = Companies::where('company_CIF', $validated['companyCIF'])->first();

            error_log('Empresa creada: ' . $company->company_id);

            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = bcrypt('M4r1a.25');
            $user->company_id = $company->company_id;
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
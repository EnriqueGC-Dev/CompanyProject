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
use App\Models\UserProfile;
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

            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = bcrypt('M4r1a.25');
            $user->user_role_id = 2; // Asignar el rol de director por defecto al crear la empresa
            $user->company_id = $company->company_id;
            $user->save();

            //obtener el ID del usuario recién creado
            $user = User::where('email', $validated['email'])->first();

            // Crear el perfil del usuario
            $userProfile = new UserProfile();
            $userProfile->user_id = $user->id;
            $userProfile->user_company_admin = true; // Asignar como administrador de la empresa
            $userProfile->save();  

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
                ], 201);
            }

            // Verificar que la fecha de finalización de la suscripción no haya expirado
            $company = Companies::find($user->company_id);
            if ($company && strtotime($company->company_end_subscription) < time()) {
                Auth::logout();
                return response()->json([
                    'status' => 'ERROR',
                    'message' => 'Tu suscripción ha expirado. Por favor, contacta con el administrador.'
                ], 201);
            }

            // Iniciar sesión exitosamente
            return response()->json([
                'status' => 'OK',
                'server' => $_SERVER,
                'cookies' => $_COOKIE,
                'environment' => $_ENV
            ], 200);

            //Error al iniciar sesión sin controlar
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

    // Obtener el objeto User por id
    public function userById($id)
    {
        $user = User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.user_role_id',
            'users.user_active',
            'user_profiles.user_photo',
            'user_profiles.user_phone',
            'user_profiles.user_birthday',
            'user_profiles.user_company_admin'
            )
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->where('users.id', $id)
            ->first();

        // Verificar si el usuario existe
        if (!$user) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Usuario no encontrado'
            ], 404);
        }
        return response()->json([
            'status' => 'OK',
            'user' => $user
        ], 200);
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

    // Setear password primer login
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
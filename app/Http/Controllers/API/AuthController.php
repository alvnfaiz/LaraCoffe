<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()
                ->json([
                    'message' => 'Hi '.$user->name.', welcome to home',
                    'data' => $user,
                    'access_token' => $token, 
                    'token_type' => 'Bearer', ]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    // method for user logout and delete token
    public function logout()
    {
        if(auth('sanctum')->check()){
            auth('sanctum')->user()->token()->delete();
            return response()->json(['status'=>'success','message' => 'Logout Successfully']);
        }else{
            return response()->json(['status'=>'error','message' => 'Unauthorized'], 401);
        }
        // auth()->user()->tokens()->delete();

        // return [
        //     'message' => 'You have successfully logged out and the token was successfully deleted'
        // ];
    }

    public function validLogin(Request $request)
    {
        return response()->json(['status'=>auth('sanctum')->check()]);
    }
}
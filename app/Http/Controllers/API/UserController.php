<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    public function profile(Request $request){
      if(auth('sanctum')->check()){
        return response()->json(['status'=>'success','data' => auth('sanctum')->user()]);
      }else{
        return response()->json(['status'=>'error','message' => 'Sepertinya anda belum login, atau token sudah kadaluarsa, silahkan login terlebih dahulu'], 401);
      }
    }

    public function user(Request $request){
      if(auth('sanctum')->check()){
        return response()->json(['status'=>'success','data' => auth('sanctum')->user()]);
      }else{
        return response()->json(['status'=>'error','message' => 'Sepertinya anda belum login, atau token sudah kadaluarsa, silahkan login terlebih dahulu'], 401);
      }
    }

    public function userList(){
      if(auth('sanctum')->check()){
        $user = User::all();
        return response()->json(['status'=>'success','data' => $user]);
      }else{
        return response()->json(['status'=>'error','message' => 'Sepertinya anda belum login, atau token sudah kadaluarsa, silahkan login terlebih dahulu'], 401);
      }
    }
}
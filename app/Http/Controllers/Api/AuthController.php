<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials))
        {
            $user = Auth::user();

            $token = $user->createToken('Yeni')->plainTextToken;

            $data=[

                "user" => Auth::user(),
                "token"=>$token

            ];



            return response()->json($data, status:200);
        }

        return response()->json(['error' => 'Kimlik doğrulama başarısız'], 401);
    }



      public function logout(Request $request)
    {
        $user = $request->user();


        $tokens = $user->tokens;


        foreach ($tokens as $token)
        {
            $token->delete();
        }


        Auth::guard('web')->logout();

        return response()->json(['message' => 'Oturum başarıyla sonlandırıldı']);
    }



    public function register(UserRequest $request)
    {


        $role = $request->has('role') ;

            $user = User::create([
                'name' => $request->name,

                'surname' => $request->surname,

                'city' => $request->city,

                'gender' => $request->gender,

                'phone' => $request->phone,

                'email' => $request->email,

                "password"=>\Hash::make($request->password),

                'role' => $role,
            ]);

           $token=$user->createToken('Token')->accessToken;

          return response()->json(['message' => 'Kullanıcı başarıyla kaydedildi'], 200);


    }




    public function Update(UserUpdateRequest $request ,$id)
    {
        $user= User::findOrFail($id);

        if($user)
        {

            $user->update([
                'name' => $request->filled('name') ? $request->name : $user->name,

                'surname' => $request->filled('surname') ? $request->surname : $user->surname,

                'city' => $request->filled('city') ? $request->city : $user->city,

                'gender' => $request->filled('gender') ? $request->gender : $user->gender,

                'phone' => $request->filled('phone') ? $request->phone : $user->phone,

                'email' => $request->filled('email') ? $request->email : $user->email,

                'password' => $request->filled('password') ? \Hash::make($request->password) : $user->password,

                'role' => $request->filled('role') ? $request->role : $user->role,
            ]);

            return response()->json(['message' => 'Kullanıcı başarıyla güncellendi'], 200);

        }

        else
        {

            return response()->json(['error' => 'Kullanıcı bulunamadı'], 404);
        }
    }


    public function softDelete($id)
    {

        $user= User::find($id);

        if($user)
        {
          $user->delete();

          return response()->json(['message' => 'Kullanıcı başarıyla silindi'], 200);
        }

        else
        {

            return response()->json(['error' => 'Kullanıcı bulunamadı'], 404);
        }

    }


    public function hardDelete($id)

    {

        $user = User::withTrashed()->find($id);

        if($user)
        {
          $user->forcedelete();

          return response()->json(['message' => 'Kullanıcı Geri Dönüşümsüz Olarak başarıyla silindi'], 200);
        }

        else
        {

            return response()->json(['error' => 'Kullanıcı bulunamadı'], 404);
        }

    }


}

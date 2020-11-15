<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;


class PassportController extends Controller
{

    use RegistersUsers;

    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {


        $validator = Validator::make($request->all(),[
         'email' => 'required|string|email|max:255|unique:users',
         'name' => 'required',
         'password'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);

        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $data['token'] = $user->createToken('MySecret')->accessToken;

        return response()->json(['data' => $data], 200,[],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('MySecret')->accessToken;

            $data = $request->all();
            $data['token'] = $token;
            $data['user'] = auth()->user();
            $data['status'] = true;

            return response()->json(['data' => $data], 200,[],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401,[],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200,[],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}

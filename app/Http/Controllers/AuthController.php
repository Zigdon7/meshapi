<?php

namespace App\Http\Controllers;

use App\Notifications\SignupActivate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Person;
use App\Models\Whitelist;


class AuthController extends Controller
{
    /*
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    { }


    public function signup(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $request->email)->get();
        if (count($user) == 0) {
            $people = Person::where('email', $request->email)->get();
            $whitelist = Whitelist::where('email', $request->email)->get();
            if (count($people) > 0) {
                $user = new User([
                    'name' => $people->first()->name_first . ' ' . $people->first()->name_last,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'activation_token' => str_random(60)
                ]);
                $user->save();
                $user->notify(new SignupActivate($user));
                return response()->json([
                    'message' => 'Successfully created user!'
                ], 200);
            } elseif (count($whitelist) > 0) {
                $user = new User([
                    'name' => $whitelist->first()->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'activation_token' => str_random(60)
                ]);
                $user->save();
                $user->notify(new SignupActivate($user));
                return response()->json([
                    'message' => 'Successfully created user!'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Not an email in our system'
                ], 200);
            }
        } else {
            return response()->json([
                'message' => 'Account already exists!'
            ], 400);
        }
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credentials = request(['email', 'password']);
        // $credentials['active'] = 1;
        // $credentials['deleted_at'] = null;
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $user_id = $user->id;
        $person = Person::where('email', $request->email)->get();
        if ($user->active == 1) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addWeeks(3);
            $token->save();
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_in' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user_id' => $user_id,
                'person_id' =>count($person) > 0 ? $person->first()->id : 0
            ]);
        } else {
            return response()->json([
                'message' => 'Please activate your account!'
            ], 400);
        }
    }
    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return $user;
    }
    /*
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /*
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /*
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /*
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'user' => auth()->user(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\User;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Bridge\AccessToken;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $log = $request->num;
        $pas = $request->pas;
        if (Auth::attempt(['number_personnel' => $log, 'password' => $pas])) {
            $user = Auth::user();
        } else {
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422
            ], 422);
        }

        // Проверяем существует ли пользователь с указанным email адресом
        // $user = User::whereEmail(request('username'))->first();

        // Внутренний API запрос для получения токенов
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        // Убедимся, что Password Client существует в БД (т.е. Laravel Passport
        // установлен правильно)
        if (!$client) {
            return response()->json([
                'message' => 'Laravel Passport is not setup properly.',
                'status' => 500
            ], 500);
        }

        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $user->email,
            'password' => $pas,
        ];

        $requestdata = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($requestdata);
        // Проверяем был ли внутренний запрос успешным
        if ($response->getStatusCode() != 200) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422
            ], 422);
        }

        // Вытаскиваем данные из ответа
        $data = json_decode($response->getContent());

        // Формируем окончательный ответ в нужном формате
        return response()->json([
            'token' => $data->access_token,
            'user' => $user,
            'status' => 200
        ]);
    }

    public function get1()
    {
        $user = auth()->user();
        return $user;
    }

    public function getUser()
    {
        return auth()->user();
    }

    public function Logout()
    {
        $user = auth()->user();
        $accessToken = DB::table('oauth_access_tokens')->where('user_id', $user->id)->where('revoked', false)->get();
        DB::table('oauth_access_tokens')
            ->where('id', $accessToken[0]->id)
            ->update([
                'revoked' => true
            ]);
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken[0]->id)
            ->update([
                'revoked' => true
            ]);


        return response()->json(['status' => 200]);
    }
}

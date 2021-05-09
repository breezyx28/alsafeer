<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(UsersRequest $request)
    {
        $validate = (object) $request->validated();

        $user = new \App\Models\User();

        foreach ($validate as $key => $value) {

            if ($validate->$key == 'password') {
                $user->password = null;
            }

            if ($validate->$key == 'birthDate') {

                $user->birthDate = date('Y-m-d', strtotime($validate->birthDate));
            }

            $user->$key = $value;
        }

        if (isset($validate->thumbnail)) {
            // $user->thumbnail = null;
            $user->thumbnail = $request->file('thumbnail')->storePublicly('Profile');
        }
        $user->password = Hash::make($request->password);
        $user->role_id = 3;

        try {
            $user->save();

            return Resp::Success('تم إنشاء مستخدم بنجاح', $user);
        } catch (\Exception $e) {
            return Resp::Error('حدث خطأ ما', $e);
        }
    }
}

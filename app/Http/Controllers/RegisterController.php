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

            $user->$key = $value;
        }

        $user->password = Hash::make($request->password);

        try {
            $user->save();

            return Resp::Success('تم إنشاء مستخدم بنجاح', $user);
        } catch (\Exception $e) {
            return Resp::Error('حدث خطأ ما', $e);
        }
    }
}

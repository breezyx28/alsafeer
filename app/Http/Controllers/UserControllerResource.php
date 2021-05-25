<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\updateUsersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Hash;

class UserControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Resp::Success('تم', \App\Models\User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(updateUsersRequest $request, User $user)
    {
        $validate = $request->validated();
        $count = \App\Models\User::where('role', 'مدير')->count();

        foreach ($validate as $key => $value) {
            if ($key === 'role' && $count < 2) {

                return Resp::Error('لا يمكن تحديث حالة المدير ... هذا حساب المدير الوحيد');
            }
            $user->$key = $value;
        }

        try {
            $user->save();
            return Resp::Success('تمت التحديث بنجاح', $user);
        } catch (\Throwable $th) {
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return Resp::Success('تم الحذف', $user);
    }
}

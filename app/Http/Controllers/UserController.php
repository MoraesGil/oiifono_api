<?php

namespace App\Http\Controllers;

use App\Entities\Person;
use App\Entities\User;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function updatePassword(UserPasswordRequest $request)
    {

        if(!Hash::check($request->get("password_old"), Auth::user()->password))
        return $this->checkOldCredentials();

        return response()->json(User::findOrFail(Auth::user()->id)->update([
            'password' => Hash::make($request->get('password'))
        ]), 200);
    }

    public function update(UpdateUserRequest $request)
    {
        $person = Person::query()
            ->with(['doctor', 'individual', 'company'])
            ->findOrFail(Auth::user()->person_id);

        $person = DB::transaction(function () use ($person, $request) {
            $person->update($request->all());

            if ($person->doctor) {
                $person->doctor->update(
                    array_merge(['register' => $request->input('crfa')], $request->all())
                );
            }
            if ($person->company) $person->company->update($request->all());
            if ($person->individual) $person->individual->update($request->all());

            return $person;
        });

        return $person;
    }

    protected function checkOldCredentials()
        {
            return [
                'errors' => [
                    'password_old' => 'Senha anterior não confere.'
                ]
            ];
        }
}

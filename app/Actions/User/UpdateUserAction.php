<?php

namespace App\Actions\User;

use App\Http\Requests\UpdateAccountRequest;
use App\Models\User;

class UpdateUserAction
{
    public function execute(UpdateAccountRequest $request): User
    {
        user()->update([
            'email' => $request->input('email'),
            'dob' => $request->input('dob'),
            'timezone' => $request->input('timezone'),
            'date_format' => $request->input('date_format'),
        ]);

        return user()->refresh();
    }
}

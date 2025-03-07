<?php

namespace App\Actions\User;

use App\Http\Requests\UpdateAccountRequest;
use App\Models\User;

class UpdateUserAction
{
    public function execute(UpdateAccountRequest $request): User
    {
        $validated = $request->validated();

        user()->update([
            'country_id' => $validated['country'],
            'email' => $validated['email'],
            'timezone' => $validated['timezone'],
            'date_format' => $validated['date_format'],
        ]);

        return user()->refresh();
    }
}

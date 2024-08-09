<?php
namespace App\Actions\Fortify;

use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric'],
            'height' => ['required', 'numeric'],
            'age' => ['required', 'integer'],
            'training_intership' => ['required', 'integer'],
            'desc' => ['required', 'string'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'surname' => $input['surname'],
            'weight' => $input['weight'],
            'height' => $input['height'],
            'age' => $input['age'],
            'training_intership' => $input['training_intership'],
            'desc' => $input['desc'],
            'role_id' => $input['role_id'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}

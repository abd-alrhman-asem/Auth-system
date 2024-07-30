<?php

namespace App\Services\Auth\RegisterService;

use App\Events\UserRegisteredEvent;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterService implements RegisterServiceInterface
{
    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return void
     * @throws \Exception
     */
    public function register(RegisterRequest $request): void
    {
        if (!$user = $this->createUser($request))
            throw  new \Exception('the register is not working , pleas try again ');
        event(new UserRegisteredEvent($user));
    }

    /**
     * @param RegisterRequest $request
     * @return User
     */
    /*private function createUser(RegisterRequest $request): User
    {
        // Prepare the data for user creation
        $data = $request->validated();

        // Hash the password securely
        $data['password'] = Hash::make($data['password']);

//        $ss = $request->file('profile_photo');
//        $ss->store('profile_photo');
//        dd($ss);
        //        dd($data['profile_photo']);
        // Handle profile photo
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            if ($file->isValid()) {
//            $data['profile_photo'] = $request->file('profile_photo')->store('profile_photos');
                $data['profile_photo'] = $file->store('profile_photos');
            }
            // Handle certificate file
            if ($request->hasFile('certificate')) {
                dd('☻☻there is here error ');
                $data['certificate'] = $request->file('certificate')->store('certificates');
            }

            // Create the user with the prepared data
        }
            return User::create($data);


    }*/
    private function createUser(RegisterRequest $request): User
    {
        // Prepare the data for user creation
        $data = $request->validated();

        // Hash the password securely
        $data['password'] = Hash::make($data['password']);

        // Handle profile photo
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            if ($file->isValid()) {
                $data['profile_photo'] = $file->store('profile_photos');
            } else {
                // Handle invalid file
                // You can log the error or return a specific response
                throw new \Exception();
            }
        }

        // Handle certificate file
        if ($request->hasFile('certificate')) {
            $certificateFile = $request->file('certificate');
            if ($certificateFile->isValid()) {
                $data['certificate'] = $certificateFile->store('certificates');
            } else {
                // Handle invalid file
                return back()->withErrors(['certificate' => 'The uploaded certificate is invalid.']);
            }
        }

        // Create the user with the prepared data
        return User::create($data);
    }

}

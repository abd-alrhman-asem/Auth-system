<?php

namespace App\Services\Auth\RegisterService;

use App\Events\UserRegisteredEvent;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Traits\FileManager;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterService implements RegisterServiceInterface
{
    use FileManager;
    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return void
     * @throws Exception
     */
    public function register(RegisterRequest $request): void
    {
        if (!$user = $this->createUser($request))
            throw  new Exception('the register operation is not working , pleas try again ');
        event(new UserRegisteredEvent($user));
    }

    /**
     * @param RegisterRequest $request
     * @return User
     * @throws Exception
     */
    public function createUser(RegisterRequest $request): User
    {
        // Prepare the data for user creation
        $data = $this->prepareUserData($request);

        // Create the user with the prepared data
        return User::create($data);
    }

    /**
     * @param RegisterRequest $request
     * @return array
     */
    private function prepareUserData(RegisterRequest $request): array
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['profile_photo'] = $this->handleFileUpload($request, 'profile_photo', 'profile_photos');
        $data['certificate'] = $this->handleFileUpload($request, 'certificate', 'certificates');
        return $data;
    }

    /**
     * @param RegisterRequest $request
     * @param string $fileKey
     * @param string $disk
     * @return string|null
     */
    private function handleFileUpload(RegisterRequest $request, string $fileKey, string $disk): ?string
    {
        if ($request->hasFile($fileKey) && $request->file($fileKey)->isValid()) {
            return $this->storeFile($request->file($fileKey) , $disk);
        }
        return null;
    }



}

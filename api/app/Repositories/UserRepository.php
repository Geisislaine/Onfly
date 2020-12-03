<?php


namespace App\Repositories;


use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->user = $user;
    }

    public function getByEmail($email)
    {
        try {
            $response = $this->user->where('email', $email)->first();
            return $response;
        } catch (\Exception $e) {
            throw new \Exception($e);
        }

    }
}

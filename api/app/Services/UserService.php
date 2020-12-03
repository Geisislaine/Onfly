<?php


namespace App\Services;


use App\Repositories\UserRepository;

class UserService extends BaseService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct($userRepository);
        $this->userRepository = $userRepository;
    }

    function salvar($dados)
    {
        try {
            $fotoPerfil = $dados['fotoPerfil'];
            if($fotoPerfil != "null"){
                $fotoPerfil = $fotoPerfil->store('fotoPerfil');
            }
            $dados['fotoPerfil'] = $fotoPerfil;
            $dados['password'] = bcrypt($dados['password']);
            $response = $this->userRepository->salvar($dados);
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }

    public function uniqueEmail($email)
    {
        try {
            $user = $this->userRepository->getByEmail($email);
            if (isset($user)) {
                return response()->json(['duplicado' => 1]);
            }
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
        return response()->json(['duplicado' => 0]);
    }
}

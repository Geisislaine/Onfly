<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Helpers\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try{
            $response = $this->userService->listar();
        }catch (\Exception $e) {
            Log::error($e);
            if (!env('APP_DEBUG')) {
                return Utils::ResponseJson(new \Exception("Erro ao listar os usuarios, contate o administrado do sistema!"));
            }
            return Utils::ResponseJson($e);
        }
        return Utils::ResponseJson($response);
    }

    public function show($id)
    {
        try{
            $response = $this->userService->listarPorId($id);
        }catch (\Exception $e) {
            Log::error($e);
            if (!env('APP_DEBUG')) {
                return Utils::ResponseJson(new \Exception("Erro ao listar o usuario, contate o administrado do sistema!"));
            }
            return Utils::ResponseJson($e);
        }
        return Utils::ResponseJson($response);
    }

    public function store(Request $request)
    {
        try{
            $response = $this->userService->salvar($request->all());
        }catch (\Exception $e) {
            Log::error($e);
            if (!env('APP_DEBUG')) {
                return Utils::ResponseJson(new \Exception("Erro ao salvar os dados, contate o administrado do sistema!"));
            }
            return Utils::ResponseJson($e);
        }
        return Utils::ResponseJson($response);
    }

    public function update($id, Request $request)
    {
        try{
            $response = $this->userService->atualizar($id, $request->all());
        }catch (\Exception $e) {
            Log::error($e);
            if (!env('APP_DEBUG')) {
                return Utils::ResponseJson(new \Exception("Erro ao atualizar os dados, contate o administrado do sistema!"));
            }
            return Utils::ResponseJson($e);
        }
        return Utils::ResponseJson($response);
    }

    public function destroy($id)
    {
        try{
            $response = $this->userService->deletar($id);
        }catch (\Exception $e) {
            Log::error($e);
            if (!env('APP_DEBUG')) {
                return Utils::ResponseJson(new \Exception("Erro ao deletar os dados, contate o administrado do sistema!"));
            }
            return Utils::ResponseJson($e);
        }
        return Utils::ResponseJson($response);
    }

    public function UniqueEmail($email)
    {
        try {
            $response = $this->userService->uniqueEmail($email);
        } catch (\Exception $e) {
            Log::error($e);
            if (!env('APP_DEBUG')) {
                return Utils::ResponseJson(new \Exception("Erro ao validar email, contacte o administrador"));
            }
            return Utils::ResponseJson($e);
        }

        return $response;
    }
}

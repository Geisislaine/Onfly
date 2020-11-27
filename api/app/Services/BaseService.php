<?php


namespace App\Services;


use App\Repositories\BaseRepository;


class BaseService
{
    /**
     * @var BaseRepository
     */
    private $repository;


    public function __construct(BaseRepository $repository){
        $this->repository = $repository;
    }

    function listar()
    {
        try {
            $response = $this->repository->listar();
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }

    function listarPorId($id)
    {
        try {
            $response = $this->repository->listarPorId($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }

    function salvar($dados)
    {
        try {
            $response = $this->repository->salvar($dados);
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }

    function atualizar($id, $dados)
    {
        try {
            $response = $this->repository->atualizar($id, $dados);
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }

    function deletar($id)
    {
        try {
            $response = $this->repository->deletar($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }
}
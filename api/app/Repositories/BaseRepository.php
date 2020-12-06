<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
     * @var model
     */
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function listar($userId)
    {
        try {
            $response = $this->model->where('usuario_id', $userId)->get();
        } catch (\Exception $e) {
            throw $e;
        }
        return $response;
    }

    public function listarPorId($id)
    {
        try {
            $response = $this->model->where('id', $id)->first();
        } catch (\Exception $e) {
            throw $e;
        }
        return $response;
    }

    public function salvar($dados)
    {
        try {
            $response = $this->model->create($dados);
        } catch (\Exception $e) {
            throw $e;
        }
        return $response;
    }

    public function atualizar($id, $dados)
    {
        try {
            $response = $this->model->where('id', $id)->first();
            $response->fill($dados);
            $response->save();
        } catch (\Exception $e) {
            throw $e;
        }
        return $response;
    }

    public function deletar($id)
    {
        try {
            $response = $this->model->where('id', $id)->first()->delete();
        } catch (\Exception $e) {
            throw $e;
        }
        return $response;
    }
}

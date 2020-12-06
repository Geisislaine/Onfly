<?php


namespace App\Repositories;


use App\Models\Despesa;

class DespesaRepository extends BaseRepository
{
    /**
     * @var Despesa
     */
    private $despesa;

    public function __construct(Despesa $despesa)
    {
        parent::__construct($despesa);
        $this->despesa = $despesa;
    }

    public function listarPorIdUser($userId)
    {
        try {
            $response = $this->despesa->where('usuario_id', $userId)->get();
        } catch (\Exception $e) {
            throw $e;
        }
        return $response;
    }

}

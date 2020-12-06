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

    public function listar()
    {
        try {
            $user = auth('api')->user();
            $response = $this->despesa->where('usuario_id', $user->id)->get();
        } catch (\Exception $e) {
            throw $e;
        }
        return $response;
    }

}

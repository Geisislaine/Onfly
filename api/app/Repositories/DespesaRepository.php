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

}

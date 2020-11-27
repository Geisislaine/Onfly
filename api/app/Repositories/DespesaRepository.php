<?php


namespace App\Repositories;


use App\Models\Despesa;

class DespesaRepository extends BaseRepository
{

    public function __construct(Despesa $despesa)
    {
        parent::__construct($despesa);
    }

}

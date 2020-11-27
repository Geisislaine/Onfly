<?php


namespace App\Services;


use App\Repositories\DespesaRepository;

class DespesaService extends BaseService
{

    public function __construct(DespesaRepository $despesaRepository)
    {
        parent::__construct($despesaRepository);
    }

}

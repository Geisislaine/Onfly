<?php


namespace App\Services;


use App\Repositories\DespesaRepository;
use Illuminate\Support\Facades\Storage;

class DespesaService extends BaseService
{
    /**
     * @var DespesaRepository
     */
    private $despesaRepository;

    public function __construct(DespesaRepository $despesaRepository)
    {
        parent::__construct($despesaRepository);
        $this->despesaRepository = $despesaRepository;
    }

    function salvar($dados)
    {
        try {
            $anexo = $dados['anexo'];
            if($anexo != "null"){
                $anexo = $anexo->store('anexos');
            }
            $dados['anexo'] = $anexo;
            $response = $this->despesaRepository->salvar($dados);
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }

    function atualizar($id, $dados)
    {
        try {
            $anexo = $dados['anexo'];
            if($anexo != "null"){
                $anexo = $anexo->store('anexos');
            }

            if($id != null && $id != "null"){
                try{
                    $AnexoAnterior = $this->despesaRepository->listarPorId($id);
                    if (is_file('anexos' . $AnexoAnterior['anexo'])) {
                        Storage::delete('anexos' . $AnexoAnterior['anexo']);
                    }
                } catch (\Exception $e) {
                    throw $e;
                }

            }

            $dados['anexo'] = $anexo;
            $response = $this->despesaRepository->atualizar($id, $dados);
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }
}

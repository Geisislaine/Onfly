<?php


namespace App\Services;


use App\Repositories\DespesaRepository;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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

    public function salvar($dados)
    {
        try {
            $anexo = $dados['anexo'];
            if($anexo != "null"){
                $anexo = $anexo->store('anexos');
            }
            $dados['anexo'] = $anexo;
            $dados['data'] = Carbon::createFromFormat('d/m/Y', $dados['data'])->toDateString();
            $response = $this->despesaRepository->salvar($dados);
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }

    public function atualizar($id, $dados)
    {
        try {
            $dados['data'] = Carbon::createFromFormat('d/m/Y', $dados['data'])->toDateString();
            $dados['valor'] = str_replace("R$", "", $dados['valor']);
            $dados['valor'] = str_replace(",", ".", $dados['valor']);
            $response = $this->despesaRepository->atualizar($id, $dados);
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }

    public function deletar($id)
    {
        try {
            $despesa = $this->despesaRepository->listarPorId($id);
            if (is_file($despesa['anexo'])) {
                Storage::delete($despesa['anexo']);
            }
            $response = $this->despesaRepository->deletar($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }

    public function salvarArquivo($id, $request)
    {
        try{
            $despesa = $this->despesaRepository->listarPorId($id);
            if (is_file($despesa['anexo'])) {
                Storage::delete($despesa['anexo']);
            }

            $anexo = $request['anexo'];
            if($anexo != "null"){
                $anexo = $anexo->store('anexos');
            }

        }catch (\Exception $e){
            throw $e;
        }
        return $anexo;
    }

    public  function listarPorIdUser($userId)
    {
        try {
            $response = $this->despesaRepository->listarPorIdUser($userId);
        }catch (\Exception $e){
            throw $e;
        }
        return $response;
    }
}

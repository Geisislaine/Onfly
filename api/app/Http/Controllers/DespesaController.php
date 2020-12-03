<?php

namespace App\Http\Controllers;

use App\Services\DespesaService;
use Illuminate\Http\Request;
use App\Helpers\Utils;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DespesaController extends Controller
{
    /**
     * @var DespesaService
     */
    private $despesaService;

    public function __construct(DespesaService $despesaService)
    {
        $this->despesaService = $despesaService;
    }

    function listar()
    {
        try{
            $response = $this->despesaService->listar();
        }catch (\Exception $e) {
            Log::error($e);
            if (!env('APP_DEBUG')) {
                return Utils::ResponseJson(new \Exception("Erro ao listar as despesas, contate o administrado do sistema!"));
            }
            return Utils::ResponseJson($e);
        }
        return Utils::ResponseJson($response);
    }

    function listarPorId($id)
    {
        try{
            $response = $this->despesaService->listarPorId($id);
        }catch (\Exception $e) {
            Log::error($e);
            if (!env('APP_DEBUG')) {
                return Utils::ResponseJson(new \Exception("Erro ao listar a despesa, contate o administrado do sistema!"));
            }
            return Utils::ResponseJson($e);
        }
        return Utils::ResponseJson($response);
    }

    function salvar(Request $request)
    {
        $this->validacao($request->all());

        try{
            $response = $this->despesaService->salvar($request->all());
        }catch (\Exception $e) {
            Log::error($e);
            if (!env('APP_DEBUG')) {
                return Utils::ResponseJson(new \Exception("Erro ao salvar as despesas, contate o administrado do sistema!"));
            }
            return Utils::ResponseJson($e);
        }
        return Utils::ResponseJson($response);
    }

    function atualizar($id, Request $request)
    {
        $this->validacao($request->all());

        try{
            $response = $this->despesaService->atualizar($id, $request->all());
        }catch (\Exception $e) {
            Log::error($e);
            if (!env('APP_DEBUG')) {
                return Utils::ResponseJson(new \Exception("Erro ao atualizar as despesas, contate o administrado do sistema!"));
            }
            return Utils::ResponseJson($e);
        }
        return Utils::ResponseJson($response);
    }

    function deletar($id)
    {
        try{
            $response = $this->despesaService->deletar($id);
        }catch (\Exception $e) {
            Log::error($e);
            if (!env('APP_DEBUG')) {
                return Utils::ResponseJson(new \Exception("Erro ao deletar a despesa, contate o administrado do sistema!"));
            }
            return Utils::ResponseJson($e);
        }
        return Utils::ResponseJson($response);
    }

    private function validacao($request)
    {
        $campos =  [
            'descricao' => 'Descrição da despesa',
            'data' => 'A data da despesa',
            'valor' => 'O valor da despesa',
        ];

        $validator = Validator::make($request, [
            'descricao' => 'required|max:255',
            'data' => 'required',
            'valor' => 'required'
        ], [], $campos);


        if ($validator->fails()) {
            abort(Utils::ResponseJsonValidation($validator->errors()));
        }
    }
}

<?php

namespace App\Controller;

use Exception;
use App\Entity\Especialidade;
use App\Services\VerifierService;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EspecialidadeRepositoryInterface;
use Symfony\Component\HttpFoundation\{JsonResponse,Request,Response};

class EspecialidadeController
{
    public function __construct(
        private readonly EspecialidadeRepositoryInterface $especialidadeRepository,
        private readonly VerifierService $verificador
    ){}

    /**
     * @Route("especialidades", methods={"POST"})
     * @throws Exception
     */
    public function cadastraEspecialidade(Request $request): Response
    {
        $dados = json_decode($request->getContent());
        $arraydados = get_object_vars($dados);

        $this->verificador->verificaCamposObrigatorios($arraydados,['descricao']);
        $this->verificador->verificaCamposVaziosOuNulos($arraydados);

        $especialidade = new Especialidade($dados->descricao);
        $this->especialidadeRepository->save($especialidade);

        return new JsonResponse($especialidade);
    }

    /**
     * @Route("especialidades", methods={"GET"})
     */
    public function buscaTodasEspecialidades():Response
    {
        $listaEspecialidades = $this->especialidadeRepository->findAll();
        return new JsonResponse($listaEspecialidades);
    }

    /**
     * @Route("especialidades/{id}", methods={"GET"})
     */
    public function buscaEspecialidadePorId(int $id):Response
    {
        $especialidade = $this->especialidadeRepository->find($id);
        $statusCode =  is_null($especialidade)? 204 : 200;

        return new JsonResponse($especialidade,$statusCode);
    }

    /**
     * @Route("especialidades/{id}", methods={"PUT"})
     * @throws Exception
     */
    public function atualizaEspecialidadePorId(int $id, Request $request): Response
    {
        $especialidadeExistente = $this->especialidadeRepository->find($id);

        if(is_null($especialidadeExistente)){
            return new JsonResponse('Especialidade nao encontrada',404);
        }

        $dados = json_decode($request->getContent());
        $arraydados = get_object_vars($dados);

        $this->verificador->verificaCamposObrigatorios($arraydados,['descricao']);
        $this->verificador->verificaCamposVaziosOuNulos($arraydados);

        $novaEspecialidade = new Especialidade($dados->descricao);

        $especialidadeExistente->setDescricao($novaEspecialidade->getDescricao());

        $this->especialidadeRepository->save($especialidadeExistente);
        return new JsonResponse($especialidadeExistente);
    }

    /**
     * @Route("especialidades/{id}", methods={"DELETE"})
     * @throws Exception
     */
    public function deletaEspecialidade(int $id): Response
    {
        $especialidade = $this->especialidadeRepository->find($id);

        if (is_null($especialidade)){
            return new JsonResponse('Médico nao encontrado',404);
        }

        $this->especialidadeRepository->delete($especialidade);

        return new JsonResponse('',204);
    }
}
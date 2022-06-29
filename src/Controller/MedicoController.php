<?php

namespace App\Controller;

use Exception;
use App\Entity\Medico;
use App\Services\VerifierService;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\{EspecialidadeRepositoryInterface,MedicoRepositoryInterface};
use Symfony\Component\HttpFoundation\{JsonResponse,Request,Response};

class MedicoController
{
    public function __construct(
        private readonly MedicoRepositoryInterface $medicoRepository,
        private readonly EspecialidadeRepositoryInterface $especialidadeRepository,
        private readonly VerifierService $verificador
    ){}

    /**
     * @Route("medicos", methods={"POST"})
     * @throws Exception
     */
    public function cadastraMedico(Request $request): Response
    {
       $dados = json_decode($request->getContent());

       $arraydados = get_object_vars($dados);

       $this->verificador->verificaCamposObrigatorios($arraydados,['crm','nome','especialidade']);
       $this->verificador->verificaCamposVaziosOuNulos($arraydados);

       if(is_null($this->especialidadeRepository->find($dados->especialidade))){
           throw new Exception('Especialidade não encontrada', 404);
       }

       $especialidade = $this->especialidadeRepository->find($dados->especialidade);

       $medico = new Medico($dados->nome, $dados->crm, $especialidade);

       $this->medicoRepository->save($medico);

       return new JsonResponse($medico);
    }

    /**
     * @Route("medicos", methods={"GET"})
     */
    public function buscaTodosMedicos(): Response
    {
        $listaMedicos = $this->medicoRepository->findAll();

        return new JsonResponse($listaMedicos);
    }

    /**
     * @Route("medicos/{id}", methods={"GET"})
     */
    public function buscaMedicoPorId(int $id): Response
    {
        $medico = $this->medicoRepository->find($id);
        $statusCode =  is_null($medico)? 204 : 200;

        return new JsonResponse($medico,$statusCode);
    }

    /**
     * @Route("medicos/{id}", methods={"PUT"})
     * @throws Exception
     */
    public function atualizaMedicoPorId(int $id, Request $request): Response
    {
        if(is_null($this->medicoRepository->find($id))){
            return new JsonResponse('Medico nao encontrado',404);
        }

        $medicoExistente = $this->medicoRepository->find($id);

        $dados = json_decode($request->getContent());

        $arraydados = get_object_vars($dados);

        $this->verificador->verificaCamposObrigatorios($arraydados,['crm','nome','especialidade']);
        $this->verificador->verificaCamposVaziosOuNulos($arraydados);

        if(is_null($this->especialidadeRepository->find($dados->especialidade))){
            throw new Exception('Especialidade não encontrada', 404);
        }

        $medicoExistente->setNome($dados->nome);
        $medicoExistente->setCrm($dados->crm);
        $medicoExistente->setEspecialidade($this->especialidadeRepository->find($dados->especialidade));

        $this->medicoRepository->save($medicoExistente);

        return new JsonResponse($medicoExistente);
    }

    /**
     * @Route("medicos/{id}", methods={"DELETE"})
     * @throws Exception
     */
    public function deletaMedico(int $id): Response
    {
        if (is_null($this->medicoRepository->find($id))){
            return new JsonResponse('Médico nao encontrado',404);
        }

        $medico = $this->medicoRepository->find($id);

        $this->medicoRepository->delete($medico);

        return new JsonResponse('',204);
    }
}
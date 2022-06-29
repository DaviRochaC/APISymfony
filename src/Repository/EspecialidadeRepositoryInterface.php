<?php

namespace App\Repository;



use App\Entity\Especialidade;

interface EspecialidadeRepositoryInterface
{
    public function save(Especialidade $especialidade): void;

    public function delete(Especialidade $especialidade): void;

    public function findAll();

    public function find(mixed $id);
}
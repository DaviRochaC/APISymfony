<?php

namespace App\Repository;

use App\Entity\Medico;

interface MedicoRepositoryInterface
{
    public function save(Medico $medico): void;

    public function delete(Medico $medico): void;

    public function findAll();

    public function find(mixed $id);
}
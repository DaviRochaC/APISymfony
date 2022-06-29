<?php

namespace App\Repository;

use App\Entity\Medico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MedicoRepository extends ServiceEntityRepository implements MedicoRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry,Medico::class);
    }

    public function save(Medico $medico): void
    {
        $this->getEntityManager()->persist($medico);
        $this->getEntityManager()->flush();
    }

    public function delete(Medico $medico): void
    {
        $this->getEntityManager()->remove($medico);
        $this->getEntityManager()->flush();
    }

}
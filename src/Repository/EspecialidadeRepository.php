<?php

namespace App\Repository;

use App\Entity\Especialidade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EspecialidadeRepository extends ServiceEntityRepository implements EspecialidadeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Especialidade::class);
    }

    public function save(Especialidade $especialidade): void
    {
        $this->getEntityManager()->persist($especialidade);
        $this->getEntityManager()->flush();
    }

    public function delete(Especialidade $especialidade): void
    {
        $this->getEntityManager()->remove($especialidade);
        $this->getEntityManager()->flush();
    }
}

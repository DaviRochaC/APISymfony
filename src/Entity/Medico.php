<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity()
 */
class Medico implements JsonSerializable
{

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $nome;

    /**
     * @ORM\Column(type="string")
     */
    private string $crm;

    /**
     * @ORM\ManyToOne(targetEntity=Especialidade::class, inversedBy="medicos")
     * @ORM\JoinColumn(nullable=false)
     */
    private Especialidade $especialidade;

    public function __construct(string $nome, string $crm, Especialidade $especialidade)
    {
        $this->nome = $nome;
        $this->crm = $crm;
        $this->especialidade = $especialidade;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function setCrm(string $crm): void
    {
        $this->crm = $crm;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCrm(): string
    {
        return $this->crm;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEspecialidade(): Especialidade
    {
        return $this->especialidade;
    }

    public function setEspecialidade(Especialidade $especialidade): self
    {
        $this->especialidade = $especialidade;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'crm' => $this->getCrm(),
            'nome' => $this->getNome(),
            'especialidade' => $this->getEspecialidade()
        ];
    }
}
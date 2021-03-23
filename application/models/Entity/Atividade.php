<?php

namespace Entity;

/**
 * Atividade
 *
 * @Entity
 * @Table(name="atividade")
 * @author Marcos Iran<marcosiran@gmail.com>
 */
class Atividade
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @Column(name="dataCadastro", type="string",  nullable=false)
	 */
	private $dataCadastro;

	/**
	 * @OneToOne(targetEntity="Projeto")
	 * @JoinColumn(name="idProjeto", referencedColumnName="id")
	 */
	private $projeto;

	/**
	 * @Column(name="descricao", type="string", length=255, nullable=false)
	 */
	private $descricao;

	public function __construct(Projeto $projeto, $descricao)
	{
		$this->setProjeto($projeto);
		$this->setDescricao($descricao);
		$this->dataCadastro = date("Y-m-d H:i:s");
	}

	private function setProjeto(Projeto $projeto)
	{
		if(is_null($projeto)){
			throw new \InvalidArgumentException("Projeto inválido.", 400);
		}

		$this->projeto = $projeto;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getDataCadastro()
	{
		return $this->dataCadastro;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
		return $this->descricao;
	}

	public function getProjeto()
	{
		return $this->projeto;
	}
}

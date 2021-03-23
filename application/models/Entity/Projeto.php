<?php

namespace Entity;

/**
 * Projeto
 *
 * @Entity
 * @Table(name="projeto")
 * @author Marcos Iran<marcosiran@gmail.com>
 */
class Projeto
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @Column(name="descricao", type="string", length=255, nullable=false)
	 */
	private $descricao;


	public function getId()
	{
		return $this->id;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}
}

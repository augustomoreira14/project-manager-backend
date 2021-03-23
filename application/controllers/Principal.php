<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH . '/libraries/ResponseTrait.php';

class Principal extends CI_Controller
{
	use ResponseTrait;

	public function povoar()
	{
		//povoando tabela projeto
		$projeto = new Entity\Projeto;
		$projeto->setDescricao("Projeto " . rand(1, 10));
		$this->doctrine->em->persist($projeto);
		$this->doctrine->em->flush();

		for ($i = 0; $i < 10; $i++) {
			//povoando tabela atividades
			$atividade = new Entity\Atividade($projeto, "Atividade " . ($i + 1));
			$this->doctrine->em->persist($atividade);
			$this->doctrine->em->flush();
		}

		echo "Database povoado";
	}

	public function projetos()
	{
		$projetos = $this->doctrine->em->getRepository("Entity\Projeto")
			->findAll();

		$data = array_map(function(\Entity\Projeto $item) {
			return [
				'id' => $item->getId(),
				'descricao' => $item->getDescricao()
			];
		}, $projetos);

		return $this->respond($data);
	}


}

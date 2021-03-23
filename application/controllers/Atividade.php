<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include APPPATH . '/libraries/ResponseTrait.php';

class Atividade extends CI_Controller
{
	use ResponseTrait;

	public function __construct()
	{
		parent::__construct();
	}

	public function index($idProjeto)
	{
		$atividades = $this->doctrine->em->getRepository("Entity\Atividade")
			->findBy(array("projeto" => $idProjeto), array("dataCadastro" => "asc"));

		$data = array_map(function(\Entity\Atividade $item) {
			return $this->presentEntity($item);
		}, $atividades);

		return $this->respond($data);
	}

	public function get($id)
	{
		$data = [];

		$atividade = $this->doctrine->em->find("Entity\Atividade", $id);
		if($atividade){
			$data[] = $this->presentEntity($atividade);

			return $this->respond($data);
		}

		return $this->respond($data);
	}

	public function store()
	{
		try {
			$data = [
				'descricao' => $this->input->post('descricao', true),
				'projeto_id' => (int) $this->input->post('projeto_id', true)
			];

			$this->validateData($data);

			$projeto = $this->doctrine->em->getRepository("Entity\Projeto")->find($data['projeto_id']);
			if(!$projeto){
				throw new \RuntimeException("Projeto inválido.", 400);
			}

			$atividade = new Entity\Atividade($projeto, $data['descricao']);
			$atividade->setDescricao($data['descricao']);

			$this->doctrine->em->persist($atividade);
			$this->doctrine->em->flush();

			return $this->respond($this->presentEntity($atividade), 201);
		}catch (\Exception $ex) {
			return $this->respond($ex->getMessage(), $ex->getCode());
		}
	}

	public function update($id)
	{
		try {
			$data = [
				'descricao' => $this->input->put('descricao', true)
			];

			$atividade = $this->doctrine->em->find("Entity\Atividade", $id);
			if(!$atividade){
				throw new \RuntimeException("Atividade inválida.", 400);
			}

			$atividade->setDescricao($data['descricao']);
			$this->doctrine->em->flush();

			return $this->respond('Atualizado com sucesso.');

		}catch (\Exception $ex) {
			return $this->respond($ex->getMessage(), $ex->getCode());
		}
	}

	public function delete($id)
	{
		try {
			$atividade = $this->doctrine->em->find("Entity\Atividade", $id);
			if(!$atividade){
				throw new \RuntimeException("Atividade inválida.", 400);
			}

			$this->doctrine->em->remove($atividade);
			$this->doctrine->em->flush();

			return $this->respond('Deletado com sucesso.', 201);

		}catch (\Exception $ex) {
			return $this->respond($ex->getMessage(), $ex->getCode());
		}
	}

	protected function presentEntity(Entity\Atividade $atividade)
	{
		return [
			"id" => $atividade->getId(),
			"data" => $atividade->getDataCadastro(),
			"descricao" => $atividade->getDescricao(),
			"projeto" => $atividade->getProjeto()->getDescricao()
		];
	}

	protected function validateData(array $data)
	{
		foreach ($data as $key => $item) {
			if(empty($item)){
				throw new InvalidArgumentException("O campo $key é requerido.", 400);
			}
		}
	}
}

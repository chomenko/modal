<?php
/**
 * Author: Mykola Chomenko
 * Email: mykola.chomenko@dipcom.cz
 * Created: 14.12.2018
 */

namespace Chomenko\Modal;

use Nette\DI\Container;

class ModalController
{

	/**
	 * @var Container
	 */
	private $container;

	/**
	 * @var IWrappedModal
	 */
	private $modalFactory;

	/**
	 * @var ModalFactory[]
	 */
	private $modal = [];

	public function __construct(Container $container, IWrappedModal $modalFactory){
		$this->container = $container;
		$this->modalFactory = $modalFactory;
	}

	/**
	 * @param string $interface
	 */
	public function addModal(string $interface)
	{
		$factory = new ModalFactory($interface, $this->container->getByType($interface));
		$this->modal[$factory->getId()] = $factory;
	}

	/**
	 * @param string $id
	 * @return ModalFactory
	 */
	public function getById(string $id): ?ModalFactory
	{
		if (array_key_exists($id, $this->modal)) {
			return $this->modal[$id];
		}
		return NULL;
	}

	/**
	 * @param string $interface
	 * @return ModalFactory
	 */
	public function getByInterface(string $interface): ?ModalFactory
	{
		foreach ($this->modal as $modal) {
			if ($modal->getInterface() === $interface) {
				return $modal;
			}
		}
		return NULL;
	}

	/**
	 * @return ModalFactory[]
	 */
	public function getModels(): array
	{
		return $this->modal;
	}

}
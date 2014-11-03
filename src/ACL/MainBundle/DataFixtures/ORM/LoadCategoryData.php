<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACL\MainBundle\DataFixtures\ORM;

use Application\Sonata\ProductBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Category fixtures loader.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Returns the Sonata MediaManager.
     *
     * @return \Sonata\CoreBundle\Model\ManagerInterface
     */
    public function getCategoryManager()
    {
        return $this->container->get('sonata.classification.manager.category');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Alarmes category
        $alarmes = $this->getCategoryManager()->create();
        $alarmes->setName('Alarmes');
        $alarmes->setSlug('alarmes');
        $alarmes->setDescription('Descricao da categoria alarmes');
        $alarmes->setEnabled(true);
        $this->getCategoryManager()->save($alarmes);
        $this->setReference('alarmes_category', $alarmes);

        // Paineis de Alarmes category
        $paineisDeAlarmes = $this->getCategoryManager()->create();
        $paineisDeAlarmes->setParent($alarmes);
        $paineisDeAlarmes->setName('Paineis de Alarmes');
        $paineisDeAlarmes->setSlug('paineis-de-alarmes');
        $paineisDeAlarmes->setDescription('Descricao da categoria paineis de alarmes');
        $paineisDeAlarmes->setEnabled(true);
        $this->getCategoryManager()->save($paineisDeAlarmes);
        $this->setReference('alarmes_paineis_de_alarmes_category', $paineisDeAlarmes);

        // Teclados category
        $teclados = $this->getCategoryManager()->create();
        $teclados->setParent($alarmes);
        $teclados->setName('Teclados');
        $teclados->setSlug('alarmes-teclados');
        $teclados->setDescription('Descricao da categoria teclados.');
        $teclados->setEnabled(true);
        $this->getCategoryManager()->save($teclados);
        $this->setReference('alarmes_teclados_category', $teclados);

        // Módulos e Acessórios category
        $modulosEAcessorios = $this->getCategoryManager()->create();
        $modulosEAcessorios->setParent($alarmes);
        $modulosEAcessorios->setName('Módulos e Acessórios');
        $modulosEAcessorios->setSlug('alarmes-modulos-e-acessorios');
        $modulosEAcessorios->setDescription('Descrição da categoria alarmes - módulos e acessórios');
        $modulosEAcessorios->setEnabled(true);
        $this->getCategoryManager()->save($modulosEAcessorios);
        $this->setReference('alarmes_modulos_e_acessorios_category', $modulosEAcessorios);

        // Sensores ativos category
        $sensoresAtivos = $this->getCategoryManager()->create();
        $sensoresAtivos->setParent($alarmes);
        $sensoresAtivos->setName('Sensores Ativos');
        $sensoresAtivos->setSlug('alarmes-sensores-ativos');
        $sensoresAtivos->setDescription('Descrição da categoria alarmes - sensores ativos');
        $sensoresAtivos->setEnabled(true);
        $this->getCategoryManager()->save($sensoresAtivos);
        $this->setReference('alarmes_sensores_ativos_category', $sensoresAtivos);

        // Sensores Passivos category
        $sensoresPassivos = $this->getCategoryManager()->create();
        $sensoresPassivos->setParent($alarmes);
        $sensoresPassivos->setName('Sensores Passivos');
        $sensoresPassivos->setSlug('alarmes-sensores-passivos');
        $sensoresPassivos->setDescription('Descrição da categoria alarmes - sensores passivos');
        $sensoresPassivos->setEnabled(true);
        $this->getCategoryManager()->save($sensoresPassivos);
        $this->setReference('alarmes_sensores_passivos_category', $sensoresPassivos);

        // Sensores Magnéticos category
        $sensoresMagneticos = $this->getCategoryManager()->create();
        $sensoresMagneticos->setParent($alarmes);
        $sensoresMagneticos->setName('Sensores Magnéticos');
        $sensoresMagneticos->setSlug('alarmes-sensores-magneticos');
        $sensoresMagneticos->setDescription('Descrição da categoria alarmes - sensores magnéticos');
        $sensoresMagneticos->setEnabled(true);
        $this->getCategoryManager()->save($sensoresMagneticos);
        $this->setReference('alarmes_sensores_magneticos_category', $sensoresMagneticos);

        // Produtos sem fio category
        $produtosSemFio = $this->getCategoryManager()->create();
        $produtosSemFio->setParent($alarmes);
        $produtosSemFio->setName('Produtos Sem Fio');
        $produtosSemFio->setSlug('alarmes-produtos-sem-fio');
        $produtosSemFio->setDescription('Descrição da categoria alarmes - produtos sem fio');
        $produtosSemFio->setEnabled(true);
        $this->getCategoryManager()->save($produtosSemFio);
        $this->setReference('alarmes_produtos_sem_fio_category', $produtosSemFio);

        // Dispositivos especiais category
        $dispositivosEspeciais = $this->getCategoryManager()->create();
        $dispositivosEspeciais->setParent($sensoresMagneticos);
        $dispositivosEspeciais->setName('Dispositivos Especiais');
        $dispositivosEspeciais->setSlug('alarmes-dispositivos-especiais');
        $dispositivosEspeciais->setDescription('Descrição da categoria alarmes - dispositivos especiais');
        $dispositivosEspeciais->setEnabled(true);
        $this->getCategoryManager()->save($dispositivosEspeciais);
        $this->setReference('alarmes_dispositivos_especiais_category', $dispositivosEspeciais);

        // CFTV category
        $cftv = $this->getCategoryManager()->create();
        $cftv->setName('CFTV');
        $cftv->setSlug('cftv');
        $cftv->setDescription('Descrição da categoria CFTV');
        $cftv->setEnabled(true);
        $this->getCategoryManager()->save($cftv);
        $this->setReference('cftv_category', $cftv);

	    // Cameras
	    $cameras = $this->getCategoryManager()->create();
	    $cameras->setParent($cftv);
	    $cameras->setName('Câmeras');
	    $cameras->setSlug('cftv-cameras');
	    $cameras->setDescription('Descrição da categoria CFTV - Câmeras');
	    $cameras->setEnabled(true);
	    $this->getCategoryManager()->save($cftv);
	    $this->setReference('cftv_cameras_category', $cameras);


	    // Gravadores Digitais
	    $gravadoresDigitais = $this->getCategoryManager()->create();
	    $gravadoresDigitais->setParent($cftv);
	    $gravadoresDigitais->setName('Gravadores Digitais');
	    $gravadoresDigitais->setSlug('cftv-gravadores-digitais');
	    $gravadoresDigitais->setDescription('Descrição da categoria CFTV - Gravadores Digitais');
	    $gravadoresDigitais->setEnabled(true);
	    $this->getCategoryManager()->save($cftv);
	    $this->setReference('cftv_gravadores_digitais_category', $gravadoresDigitais);

	    // Acessórios
	    $acessorios = $this->getCategoryManager()->create();
	    $acessorios->setParent($cftv);
	    $acessorios->setName('Acessórios');
	    $acessorios->setSlug('cftv-acessorios');
	    $acessorios->setDescription('Descrição da categoria CFTV - Acessórios');
	    $acessorios->setEnabled(true);
	    $this->getCategoryManager()->save($cftv);
	    $this->setReference('cftv_acessorios_category', $acessorios);

	    // Acesso category
	    $acesso = $this->getCategoryManager()->create();
	    $acesso->setName('Acesso');
	    $acesso->setSlug('acesso');
	    $acesso->setDescription('Descrição da categoria Acesso');
	    $acesso->setEnabled(true);
	    $this->getCategoryManager()->save($acesso);
	    $this->setReference('acesso_category', $acesso);


	    // Controladoras
	    $controladoras = $this->getCategoryManager()->create();
	    $controladoras->setParent($acesso);
	    $controladoras->setName('Controladoras');
	    $controladoras->setSlug('acesso-controladoras');
	    $controladoras->setDescription('Descrição da categoria Acesso - Controladoras');
	    $controladoras->setEnabled(true);
	    $this->getCategoryManager()->save($controladoras);
	    $this->setReference('acesso_controladoras_category', $controladoras);

	    // Cartões
	    $cartoes = $this->getCategoryManager()->create();
	    $cartoes->setParent($controladoras);
	    $cartoes->setName('Cartões');
	    $cartoes->setSlug('acesso-controladoras-cartoes');
	    $cartoes->setDescription('Descrição da categoria Acesso - Controladoras - Cartões');
	    $cartoes->setEnabled(true);
	    $this->getCategoryManager()->save($cartoes);
	    $this->setReference('acesso_controladoras_cartoes_category', $cartoes);

	    // Leitoras
	    $leitoras = $this->getCategoryManager()->create();
	    $leitoras->setParent($controladoras);
	    $leitoras->setName('Leitoras');
	    $leitoras->setSlug('acesso-controladoras-leitoras');
	    $leitoras->setDescription('Descrição da categoria Acesso - Controladoras - Leitoras');
	    $leitoras->setEnabled(true);
	    $this->getCategoryManager()->save($leitoras);
	    $this->setReference('acesso_controladoras_cartoes_category', $leitoras);

		// Módulos
	    $modulos = $this->getCategoryManager()->create();
	    $modulos->setParent($acesso);
	    $modulos->setName('Módulos');
	    $modulos->setSlug('acesso-modulos');
	    $modulos->setDescription('Descrição da categoria Acesso - Módulos');
	    $modulos->setEnabled(true);
	    $this->getCategoryManager()->save($modulos);
	    $this->setReference('acesso_modulos_category', $modulos);

        // Great britain category
        /*$greatBritain = $this->getCategoryManager()->create();
        $greatBritain->setParent($alarmes);
        $greatBritain->setName('Great Britain');
        $greatBritain->setSlug('great-britain');
        $greatBritain->setDescription('Want to travel in Great Britain? Check out our travels.');
        $greatBritain->setEnabled(true);
        $this->getCategoryManager()->save($greatBritain);
        $this->setReference('travels_great_britain_category', $greatBritain);*/

        // London category
        /*$london = $this->getCategoryManager()->create();
        $london->setParent($alarmes);
        $london->setName('London');
        $london->setSlug('london');
        $london->setDescription('Want to travel in London? Check out our travels.');
        $london->setEnabled(true);
        $this->getCategoryManager()->save($london);
        $this->setReference('travels_london_category', $london);*/

        // Incendio category
        $incendio = $this->getCategoryManager()->create();
        $incendio->setName('Incêndio');
        $incendio->setSlug('incendio');
        $incendio->setDescription('Descrição da categoria Incêndio');
        $incendio->setEnabled(true);
        $this->getCategoryManager()->save($incendio);
        $this->setReference('incendio_category', $incendio);

        // Centrais de Incêndio
        $plushes = $this->getCategoryManager()->create();
        $plushes->setParent($incendio);
        $plushes->setName('Centrais de Incêndio');
        $plushes->setSlug('incendio-centrais-de-incendio');
        $plushes->setDescription('Descrição da categoria Incêndio - Centrais de Incêndio');
        $plushes->setEnabled(true);
        $this->getCategoryManager()->save($plushes);
        $this->setReference('incendio_centrais_de_incendio_category', $plushes);

        // Teclados
        $incendioTeclados = $this->getCategoryManager()->create();
        $incendioTeclados->setParent($incendio);
        $incendioTeclados->setName('Teclados');
        $incendioTeclados->setSlug('incendio-teclados');
        $incendioTeclados->setDescription('Descrição da categoria Incêndio - Teclados');
        $incendioTeclados->setEnabled(true);
        $this->getCategoryManager()->save($incendioTeclados);
        $this->setReference('incendio_teclados_category', $incendioTeclados);

        // Modulos Especiais
        $modulosEspeciais = $this->getCategoryManager()->create();
        $modulosEspeciais->setParent($incendio);
        $modulosEspeciais->setName('Módulos Especiais');
        $modulosEspeciais->setSlug('incendio-modulos-especiais');
        $modulosEspeciais->setDescription('Descrição da categoria Incêndio - Módulos Especiais');
        $modulosEspeciais->setEnabled(true);
        $this->getCategoryManager()->save($modulosEspeciais);
        $this->setReference('incendio_modulos_especiais_category', $modulosEspeciais);

	    // Sensores de Incêndio
	    $sensoresDeIncendio = $this->getCategoryManager()->create();
	    $sensoresDeIncendio->setParent($incendio);
	    $sensoresDeIncendio->setName('Sensores de Incêndio');
	    $sensoresDeIncendio->setSlug('incendio-sensores-de-incendio');
	    $sensoresDeIncendio->setDescription('Descrição da categoria Incêndio - Sensores de Incêndio');
	    $sensoresDeIncendio->setEnabled(true);
	    $this->getCategoryManager()->save($sensoresDeIncendio);
	    $this->setReference('incendio_sensores_de_incendio_category', $sensoresDeIncendio);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 11;
    }
}

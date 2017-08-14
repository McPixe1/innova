<?php

namespace AppBundle\Menu;

use AppBundle\Entity\Product;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder {

    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, ContainerInterface $container) {
        $this->factory = $factory;
        $this->container = $container;
    }

    public function createMainMenu(RequestStack $requestStack) {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Inicio', array('route' => 'homepage'));

        $route = $requestStack->getCurrentRequest()->get('_route');

        switch ($route) {

            case ('products'):
                $menu->addChild('Productos')->setCurrent(true);
                break;
            case ('products_filtered'):
                $menu->addChild('Productos')->setCurrent(true);
                break;

            case 'product':
                $productId = $requestStack->getCurrentRequest()->get('id');

                $em = $this->container->get('doctrine.orm.entity_manager');

                $product = $em->getRepository(Product::class)->findOneBy(array('id' => $productId));

                $productName = $product->getName();
                $menu->addChild('Productos', array('route' => 'products'));
                $menu->addChild($productName);
                break;

            case 'gallery':
                $menu->addChild('Galería')->setCurrent(true);
                break;

            case 'contact':
                $menu->addChild('Contacto')->setCurrent(true);
                break;
            case 'search':
                $menu->addChild('Búsqueda')->setCurrent(true);
                break;
        }

        return $menu;
    }

}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Product;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * 
     */
    public function indexAction(Request $request)
    {
        return $this->render('home/index.html.twig');
    }
    
    
    /**
     * @Route("/products", name="products")
     * 
     */
    public function productShowAction(){
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        
        return $this->render('home/products.html.twig', ['products' => $products]);
    }
}

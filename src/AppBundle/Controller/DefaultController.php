<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use AppBundle\Entity\Product;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     * 
     */
    public function indexAction(Request $request) {
        return $this->render('innova/home.html.twig');
    }

    
    
    /**
     * @Route("/products", name="products")
     * 
     */
    public function productShowAction() {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('innova/products.html.twig', ['products' => $products]);
    }

    
    
    /**
     * @Route("/contact", name="contact")
     * 
     */
    public function contactAction(Request $request) {

        $form = $this->createForm('AppBundle\Form\ContactType', null, array(
            'action' => $this->generateUrl('contact'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                if ($this->sendEmail($form->getData())) {
                    return $this->redirectToRoute('contact');
                } else {
                    var_dump("Error");
                }
            }
        }
        return $this->render('innova/contact.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    private function sendEmail($data) {
        $myContactMail = 'dev.pepicast@gmail.com';

        $message = \Swift_Message::newInstance()
                ->setFrom(array($myContactMail => "Mensaje de " . $data["name"]))
                ->setTo(array(
                    $myContactMail => $myContactMail
                ))
                ->setBody($this->renderView('mail/sendmail.html.twig', array(
                    'message' => $data["message"],
                    'email' => $data["email"]
                )), 'text/html');

        return $this->get('mailer')->send($message);       
    }
}

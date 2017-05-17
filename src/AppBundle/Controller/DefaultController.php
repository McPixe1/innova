<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
                    return $this->redirectToRoute('homepage');
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
        $myappContactMail = 'dev.pepicast@gmail.com';
        $myappContactPassword = 'pepicastftw'; //PONER AQUI EL PWD CORRESPONDIENTE
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
                ->setUsername($myappContactMail)
                ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance($data["subject"])
                ->setFrom(array($myappContactMail => "Mensaje de " . $data["name"]))
                ->setTo(array(
                    $myappContactMail => $myappContactMail
                ))
                ->setBody($this->renderView('mail/sendmail.html.twig', array(
                    'message' => $data["message"],
                    'email' => $data["email"]
                )), 'text/html');


        return $mailer->send($message);
    }

}

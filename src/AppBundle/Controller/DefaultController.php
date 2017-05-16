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

        // Create the form according to the FormType created previously.
        // And give the proper parameters
        $form = $this->createForm('AppBundle\Form\ContactType', null, array(
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('contact'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $form->handleRequest($request);

            if ($form->isValid()) {
                // Send mail
                if ($this->sendEmail($form->getData())) {

                    return $this->redirectToRoute('homepage');
                } else {
                    // An error ocurred, handle
                    var_dump("Errooooor :(");
                }
            }
        }

        return $this->render('innova/contact.html.twig', array(
                    'form' => $form->createView()
        ));
    }
    
     private function sendEmail($data){
        $myappContactMail = 'torres.88.bcn@gmail.com';
        $myappContactPassword = 'Mexicane88';
        
        // http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);
        
        $message = \Swift_Message::newInstance($data["subject"])
        ->setFrom(array($myappContactMail => "Mensaje de ".$data["name"]))
        ->setTo(array(
            $myappContactMail => $myappContactMail
        ))
        ->setBody($data["message"]."<br>ContactMail :".$data["email"]);
        
        return $mailer->send($message);
    }

}

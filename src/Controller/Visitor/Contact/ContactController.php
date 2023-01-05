<?php

namespace App\Controller\Visitor\Contact;

use App\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'visitor.contact.create')]
    public function create(): Response
    {
        $contect = new Contact();

        $form = $this->createForm(ContactFormType::class, $contact);

        return $this->render('pages/visitor/contact/create.html.twig',[
            "form" => $form->createView()
        ]);
    }
}

<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    #[Route('/', name: 'app_login')]
    public function login(Request $request, CustomerRepository $customerRepository): Response
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $customer = $customerRepository->findOneBy(['contactNumber' => $data['contactNumber']]);

            if (is_null($customer)) {
                $this->addFlash(
                    'danger',
                    'User with contact number ' . $data['contactNumber'] . ' does not exist'
                );

                return $this->redirectToRoute('app_login');
            }

            return $this->redirectToRoute('app_invoice_new', [
                'customer' => $customer->getId(),
            ]);
        }

        return $this->render('login/login.html.twig', [
            'form' => $form,
        ]);
    }
}

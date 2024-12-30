<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Repository\CategoryRepository;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository
    ) {
    }

    #[Route('/', name: 'app_login')]
    public function login(Request $request): Response {

        $redirectToRoute = $this->checkIfDataExists();
        if ($redirectToRoute !== '') {
            return $this->redirectToRoute($redirectToRoute);
        }

        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $customer = $this->customerRepository->findOneBy(['contactNumber' => $data['contactNumber']]);

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

    private function checkIfDataExists(): string
    {
        if ($this->customerRepository->count() === 0) {
            $this->addFlash(
                'danger',
                'There are no customers yet. Please create one.'
            );

            return 'app_customer_new';
        }

        if ($this->categoryRepository->count() === 0) {
            $this->addFlash(
                'danger',
                'There are no categories to add products. Please create a product and then visit product page.'
            );

            return 'app_category_new';
        }

        if ($this->productRepository->count() === 0) {
            $this->addFlash(
                'danger',
                'There are no products to add to invoice. Please visit add invoice page after creation of product'
            );

            return 'app_product_new';
        }

        return '';
    }
}

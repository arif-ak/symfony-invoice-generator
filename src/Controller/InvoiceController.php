<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\CustomerRepository;
use App\Repository\InvoiceRepository;
use App\Service\InvoiceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/invoice')]
class InvoiceController extends AbstractController
{
    #[Route(name: 'app_invoice_index', methods: ['GET'])]
    public function index(InvoiceRepository $invoiceRepository): Response
    {
        return $this->render('invoice/index.html.twig', [
            'invoices' => $invoiceRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/new/{customer}', name: 'app_invoice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InvoiceService $invoiceService, ?Customer $customer): Response
    {
        if ($customer === null) {
            $this->addFlash(
                'danger',
                'Please login with valid contact number'
            );

            return $this->redirectToRoute('app_login');
        }

        $invoice = new Invoice();
        $invoice->setCustomer($customer);

        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoiceService->save($invoice);

            return $this->redirectToRoute(
                'app_invoice_show',
                ['id' => $invoice->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('invoice/new.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invoice_show', methods: ['GET'])]
    public function show(Invoice $invoice): Response
    {
        return $this->render('invoice/invoice.html.twig', [
            'invoice' => $invoice,
        ]);
    }




}

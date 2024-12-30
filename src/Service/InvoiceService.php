<?php

namespace App\Service;

use App\Entity\Invoice;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class InvoiceService
{
    public function __construct(private EntityManagerInterface $entityManager, private ProductRepository $productRepository)
    {}

    public function save(Invoice $invoice): void
    {
        $productQuantities = [];
        foreach ($invoice->getInvoiceItems() as $invoiceItem) {
            $invoiceItem->setInvoice($invoice);
            $invoiceItem->setDiscountPercentage(10); //hardcoded 10% for all invoice items

            if (!array_key_exists($invoiceItem->getProduct()->getId(), $productQuantities)) {
                $productQuantities[$invoiceItem->getProduct()->getId()] = 0;
            }

            $productQuantities[$invoiceItem->getProduct()->getId()] += $invoiceItem->getQuantity();
        }

        $this->entityManager->persist($invoice);

        $products = $this->productRepository->findBy(['id' => array_keys($productQuantities)]);

        foreach($products as $product) {
            $product->setQuantity($product->getQuantity() - $productQuantities[$product->getId()]);
            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();
    }
}

<?php

use bsqr\BySquare;
use bsqr\model\Pay;
use bsqr\model\Payment;

require_once '../vendor/autoload.php';

$document = (new Pay())
	->setInvoiceId("1234567890")
	->addPayment(
		(new Payment())
			->setDueDate("2024-09-20")
			->setAmount(123.45, "EUR")
			->setSymbols("1234567890", null)
            ->addBankAccount("SK3112000000198742637543", "XXXXXXXXXXX")
	 ->setNote("Add note")
	);
$lzmaPath = BySquare::LZMA_PATH_HOMEBREW;
$bysquare = new BySquare($lzmaPath);

$svg = (string)$bysquare->render($document);

echo $svg;

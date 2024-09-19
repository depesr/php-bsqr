# BySquare

By Square document encoding, rendering and parsing utilities.

Only PayBySquare document type is currently supported.



## Requirements

This library uses `xz` system executable (`/usr/bin/xz`) for lzma compression/decompression. Path should be set in BySquare constructor.

## Instalation

`composer require depesr/php-bsqr`


## Define a PayBySquare document

```php
use bsqr;

$document = (new bsqr\model\Payment())
	->setDueDate("0000-00-00") // YYYY-MM-DD
	->setAmount(123.45, "EUR") // amount, currency code
	->setSymbols("1234567890", "308") // variable, constant symbol
	->addBankAccount("SK3112000000198742637541", "XXXXXXXXXXX") // iban, bic/swift
	->createPayDocument();
```

According to the specification, document can contain invoice ID, multiple payments,
payments can contain multiple bank accounts, extensions, etc.

```php
use bsqr;

$document = (new bsqr\model\Pay())
	->setInvoiceId("1234567890")
	->addPayment(
 		(new bsqr\model\Payment())
		->setDueDate("0000-00-00")
		->setAmount(123.45, "EUR")
		->setSymbols("1234567890", "308")
		->addBankAccount("SK3112000000198742637541", "XXXXXXXXXXX")
		->addBankAccount("SK3112000000198742637542", "XXXXXXXXXXX")
		->addBankAccount("SK3112000000198742637543", "XXXXXXXXXXX")
		// ->setNote("Payment note")
		// ->setOriginatorsReferenceInformation("Originators Reference Information")
		// ->setDirectDebitExt( /* Direct Debit Extension */ )
		// ->setStandingOrderExt( /* Standing Order Extension */ )
	)
	->addPayment( /* 2nd payment */ )
	->addPayment( /* 3rd payment */ );
```


## Render document to svg including BySqure logo and border

```php
use bsqr;

$bysquare = new bsqr\BySquare();

$svg = (string) $bysquare->render($document);
```


## Get bsqr data only

```php
use bsqr;

$bsqrCoder = new bsqr\utils\BsqrCoder();

$bsqrData = $bsqrCoder->encode($document);
```
Use any qr-code library to encode/render data to qr matrix/image.


## Parse bsqr data

```php
use bsqr;

$bsqrCoder = new bsqr\utils\BsqrCoder();

$document = $bsqrCoder->parse($bsqrData);
```


## Links

- https://github.com/prog/php-bsqr
- https://www.sbaonline.sk/projekt/projekty-z-oblasti-platobnych-sluzieb/
- https://bsqr.co/schema/
- http://www.bysquare.com/

<?php

namespace bsqr\qrcoder;

use BaconQrCode\Common\ErrorCorrectionLevel as BaconQrECLevel;
use BaconQrCode\Encoder\Encoder as BaconQrEncoder;
use bsqr\Exception;
use bsqr\mx\IMatrix;


/**
 * Data to qr-code matrix encoder
 */
class QrCoder {


	/** Level L, ~7% correction. */
	public $EC_LEVEL_L;
	/** Level M, ~15% correction. */
	public $EC_LEVEL_M;
	/** Level Q, ~25% correction. */
	public $EC_LEVEL_Q;
	/** Level H, ~30% correction. */
	public $EC_LEVEL_H;


	/** @var int */
	protected $defaultEcLevel;


	/**
	 * @param int $defaultEcLevel
	 */
	public function __construct($defaultEcLevel = null) {
		$this->EC_LEVEL_L = BaconQrECLevel::L();
		$this->EC_LEVEL_M = BaconQrECLevel::M();
		$this->EC_LEVEL_Q = BaconQrECLevel::Q();
		$this->EC_LEVEL_H = BaconQrECLevel::H();

		if (is_null($defaultEcLevel)) {
			$defaultEcLevel = $this->EC_LEVEL_L;
		}
		$this->defaultEcLevel = $defaultEcLevel;
	}


	/**
	 * Encode data to qr-code matrix.
	 *
	 * @param string $data ~ Data to encode.
	 * @param int|null $ecLevel ~ Error correction level.
	 * @return IMatrix
	 * @throws QrCoderException
	 */
	public function encode($data, $ecLevel = NULL) {
		if (is_null($ecLevel)) {
			$ecLevel = $this->defaultEcLevel;
		}
		try {
//			$qrCode = BaconQrEncoder::encode($data, BaconQrECLevel::forBits($ecLevel));
			$qrCode = BaconQrEncoder::encode($data, $ecLevel);
			return new MatrixAdapter($qrCode->getMatrix());
		} catch (\Exception $ex) {
			throw new QrCoderException("Error encoding data: " . $ex->getMessage(), 0, $ex);
		}
	}

}



/**
 * Class QrEncoderException
 */
class QrCoderException extends Exception { }

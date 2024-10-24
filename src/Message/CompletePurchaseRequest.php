<?php

namespace Omnipay\Redsys\Message;

use Symfony\Component\HttpFoundation\Request;
use Omnipay\Redsys\Encryptor\Encryptor;
use Omnipay\Redsys\Exception\BadSignatureException;
use Illuminate\Support\Facades\Log;

/**
 * Redsys Complete Purchase Request
 * @deprecated since 1.3.0 Use acceptNotification instead, which is more accurate
 */
class CompletePurchaseRequest extends PurchaseRequest
{
    /**
     * @return array
     * @throws BadSignatureException
     */
    public function getData()
    {
        Log::info('Step 1');
        $request = Request::createFromGlobals();
Log::info(json_encode($request));
        Log::info('Step 2');
        $rawParameters = $request->get('Ds_MerchantParameters');
Log::info(json_encode($rawParameters));
         Log::info('Step 3');
        $decodedParameters = json_decode(base64_decode(strtr($rawParameters, '-_', '+/')), true);
Log::info(json_encode($decodedParameters));
        Log::info('Step 4');
        if (!$this->checkSignature(
            $rawParameters,
            $decodedParameters['Ds_Order'],
            $request->get('Ds_Signature')
        )
            Log::info('Step 4 check signature');
        ) {
            throw new BadSignatureException();
        }
Log::info('Step 5');
        //check response, code "000" to "099" means success
        if ((int)$decodedParameters['Ds_Response'] <= 99) {
            Log::info('Step 5 true');
            $success = true;
        } else {
            Log::info('Step 5 false');
            $success = false;
        }
Log::info('Step return');
        return [
            'success' => $success,
            'decodedParameters' => $decodedParameters
        ];
    }

    /**
     * @param $data
     * @return CompletePurchaseResponse|PurchaseResponse
     */
    public function sendData($data)
    {
        Log::info('Send data');
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    /**
     * @param $data
     * @param $orderId
     * @param $expectedSignature
     * @return bool
     */
    private function checkSignature($data, $orderId, $expectedSignature)
    {
        $key = Encryptor::encrypt_3DES($orderId, base64_decode($this->getParameter('merchantKey')));

        return strtr(base64_encode(hash_hmac('sha256', $data, $key, true)), '+/', '-_') == $expectedSignature;
    }
}

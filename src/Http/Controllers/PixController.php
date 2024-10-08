<?php

namespace Alves\Pix\Http\Controllers;

use Alves\Pix\Exceptions\InvalidPixKeyException;
use Alves\Pix\Exceptions\PixException;
use Alves\Pix\Http\Requests\CreateQrCodeRequest;
use Alves\Pix\Payload;
use Alves\Pix\Pix;
use Symfony\Component\HttpFoundation\Response;

class PixController
{
    /**
     * @param CreateQrCodeRequest $request
     *
     * @throws PixException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateQrCodeRequest $request)
    {
        try {
            $payload = (new Payload())
                ->pixKey($request->input('key'))
                ->description($request->input('description'))
                ->merchantName($request->input('merchant_name'))
                ->merchantCity($request->input('merchant_city'))
                ->amount($request->input('amount'))
                ->transactionId($request->input('transaction_id'));
        } catch (InvalidPixKeyException $exception) {
            return response()->json($exception->getMessage());
        }

        try {
            $payload_string = $payload->getPayload();
        } catch (PixException $exception) {
            return response()->json($exception->getMessage());
        }

        $qrCode = Pix::createQrCode($payload);

        return response()->json([
            'payload'        => $payload_string,
            'base64_qr_code' => $qrCode,
        ], Response::HTTP_OK);
    }
}

<?php

namespace DrH\TendePay\Library;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Requests\BaseRequest;

class Core
{
    public function __construct(private readonly BaseClient $baseClient)
    {
    }

    public function buildEndpoint(int $requestId, Service $service): string
    {
        $baseUrl = config('tendepay.url', 'http://144.76.108.226:8180/GatewayAPIChannel/RequestProcessor');

        return "$baseUrl/$requestId/$service->name";
    }

    public function request(BaseRequest $request): array
    {
        $endpoint = $this->buildEndpoint($request->transactionReference, $request->text->getServiceCode());
        $method = 'POST';
//
//        tendePayLogInfo("request: ", [$method, $endpoint, $body]);
        $encryptedRequest = $request->getEncryptedRequest();
        $response = $this->baseClient->sendRequest($method, $endpoint, $encryptedRequest);
//        tendePayLogInfo("response: ", parseGuzzleResponse($response, false));

        return $response;
    }

    /**
     * @throws TendePayException
     */
    public function encrypt(string $plainText): string
    {
        $pub_key = config('tendepay.encryption_key');
        if (!$pub_key) {
            throw new TendePayException('Encryption key is not set');
        }

        $PK = openssl_get_publickey($pub_key);
        if (!$PK) {
            throw new TendePayException('Encryption key seems malformed');
        }

        openssl_public_encrypt($plainText, $encrypted, $PK);

        return bin2hex($encrypted);
    }
}
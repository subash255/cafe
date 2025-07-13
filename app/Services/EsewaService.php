<?php

namespace App\Services;

class EsewaService
{
    private $merchantCode;
    private $secretKey;
    private $baseUrl;

    public function __construct()
    {
        $this->merchantCode = config('services.esewa.merchant_code');
        $this->secretKey = config('services.esewa.secret_key');
        $this->baseUrl = config('services.esewa.base_url');
    }

    public function generateSignature($totalAmount, $transactionUuid, $productCode)
    {
        $message = "total_amount={$totalAmount},transaction_uuid={$transactionUuid},product_code={$productCode}";
        
        $signature = hash_hmac('sha256', $message, $this->secretKey, true);
        return base64_encode($signature);
    }

    public function getPaymentParams($order)
    {
        $transactionUuid = 'ORDER-' . $order->id . '-' . time();
        $totalAmount = $order->total_amount;
        $productCode = $this->merchantCode;

        $signature = $this->generateSignature($totalAmount, $transactionUuid, $productCode);

        return [
            'amount' => $totalAmount,
            'tax_amount' => '0',
            'total_amount' => $totalAmount,
            'transaction_uuid' => $transactionUuid,
            'product_code' => $productCode,
            'product_service_charge' => '0',
            'product_delivery_charge' => '0',
            'success_url' => route('esewa.success'),
            'failure_url' => route('esewa.failure'),
            'signed_field_names' => 'total_amount,transaction_uuid,product_code',
            'signature' => $signature,
            'form_url' => $this->baseUrl,
        ];
    }

    public function verifySignature($data)
    {
        $message = "transaction_code={$data['transaction_code']},status={$data['status']},total_amount={$data['total_amount']},transaction_uuid={$data['transaction_uuid']},product_code={$data['product_code']},signed_field_names={$data['signed_field_names']}";
        
        $signature = hash_hmac('sha256', $message, $this->secretKey, true);
        $generatedSignature = base64_encode($signature);

        return hash_equals($generatedSignature, $data['signature']);
    }

    public function checkTransactionStatus($transactionUuid, $totalAmount, $productCode)
    {
        $url = config('services.esewa.status_check_url') . "?product_code={$productCode}&total_amount={$totalAmount}&transaction_uuid={$transactionUuid}";
        
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}

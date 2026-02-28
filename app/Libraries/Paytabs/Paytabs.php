<?php

namespace Basel\Paytabs;

class Paytabs
{
    private const CREATE_PAY_PAGE_ENDPOINT = 'https://www.paytabs.com/apiv2/create_pay_page';
    private const VERIFY_PAYMENT_ENDPOINT = 'https://www.paytabs.com/apiv2/verify_payment';

    /**
     * Keep backward compatibility with the package API used in controllers.
     */
    public static function getInstance(): self
    {
        return new self();
    }

    public function create_pay_page(array $payload): object
    {
        $basePayload = [
            'merchant_email' => (string) config('paytabs.merchant_email'),
            'secret_key' => (string) config('paytabs.merchant_secretKey'),
            'site_url' => (string) config('paytabs.site_url'),
            'return_url' => (string) config('paytabs.return_url'),
            'title' => (string) ($payload['title'] ?? ''),
            'cc_first_name' => (string) ($payload['cc_first_name'] ?? ''),
            'cc_last_name' => (string) ($payload['cc_last_name'] ?? ''),
            'cc_phone_number' => (string) ($payload['cc_phone_number'] ?? ''),
            'phone_number' => (string) ($payload['phone_number'] ?? ''),
            'email' => (string) ($payload['email'] ?? ''),
            'products_per_title' => (string) ($payload['products_per_title'] ?? ''),
            'unit_price' => (string) ($payload['unit_price'] ?? ''),
            'quantity' => (string) ($payload['quantity'] ?? '1'),
            'other_charges' => (string) ($payload['other_charges'] ?? '0'),
            'amount' => (string) ($payload['amount'] ?? '0'),
            'discount' => (string) ($payload['discount'] ?? '0'),
            'currency' => (string) ($payload['currency'] ?? config('paytabs.currency', 'SAR')),
            'reference_no' => (string) ($payload['reference_no'] ?? ''),
            'ip_customer' => request()->ip(),
            'ip_merchant' => request()->server('SERVER_ADDR', '127.0.0.1'),
            'billing_address' => (string) ($payload['billing_address'] ?? ''),
            'city' => (string) ($payload['city'] ?? ''),
            'state' => (string) ($payload['state'] ?? ''),
            'postal_code' => (string) ($payload['postal_code'] ?? ''),
            'country' => (string) ($payload['country'] ?? ''),
            'address_shipping' => (string) ($payload['address_shipping'] ?? ''),
            'city_shipping' => (string) ($payload['city_shipping'] ?? ''),
            'state_shipping' => (string) ($payload['state_shipping'] ?? ''),
            'postal_code_shipping' => (string) ($payload['postal_code_shipping'] ?? ''),
            'country_shipping' => (string) ($payload['country_shipping'] ?? ''),
            'cms_with_version' => (string) config('paytabs.cms_with_version', 'API USING PHP'),
            'msg_lang' => (string) config('paytabs.msg_lang', 'en'),
        ];

        return $this->post(self::CREATE_PAY_PAGE_ENDPOINT, $basePayload);
    }

    public function verify_payment(?string $paymentReference): object
    {
        $payload = [
            'merchant_email' => (string) config('paytabs.merchant_email'),
            'secret_key' => (string) config('paytabs.merchant_secretKey'),
            'payment_reference' => (string) $paymentReference,
        ];

        return $this->post(self::VERIFY_PAYMENT_ENDPOINT, $payload);
    }

    private function post(string $url, array $payload): object
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            return (object) [
                'response_code' => 4094,
                'result' => 'Failed',
                'details' => $error ?: 'Could not connect to PayTabs.',
            ];
        }

        $decoded = json_decode($response, false);
        if (json_last_error() !== JSON_ERROR_NONE || !is_object($decoded)) {
            return (object) [
                'response_code' => 4094,
                'result' => 'Failed',
                'details' => 'Invalid response from PayTabs.',
            ];
        }

        return $decoded;
    }
}

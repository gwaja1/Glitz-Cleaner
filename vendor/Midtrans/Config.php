<?php

namespace Midtrans;

/**
 * Midtrans Configuration Class
 * Handles the configuration settings for Midtrans integration.
 */
class Config
{
    /**
     * Merchant's server key
     * Used to authenticate API requests.
     * @var string
     */
    public static $serverKey;

    /**
     * Merchant's client key
     * Used for client-side interactions.
     * @var string
     */
    public static $clientKey;

    /**
     * Determines the environment mode.
     * Set to `true` for production and `false` for sandbox mode.
     * @var bool
     */
    public static $isProduction = false;

    /**
     * Enable or disable 3D Secure.
     * Set to `true` to enable by default.
     * @var bool
     */
    public static $is3ds = false;

    /**
     * Append URL for notifications.
     * Additional endpoint for transaction updates.
     * @var string|null
     */
    public static $appendNotifUrl;

    /**
     * Override URL for notifications.
     * Replaces default notification URL.
     * @var string|null
     */
    public static $overrideNotifUrl;

    /**
     * Payment idempotency key.
     * Prevents duplicate transactions.
     * @var string|null
     */
    public static $paymentIdempotencyKey;

    /**
     * Enable request parameter sanitizer.
     * Validates and modifies charge request parameters.
     * @var bool
     */
    public static $isSanitized = false;

    /**
     * Default cURL options for requests.
     * Used to configure HTTP client behavior.
     * @var array
     */
    public static $curlOptions = [];

    /**
     * Sandbox base URL for Midtrans API.
     */
    const SANDBOX_BASE_URL = 'https://api.sandbox.midtrans.com';

    /**
     * Production base URL for Midtrans API.
     */
    const PRODUCTION_BASE_URL = 'https://api.midtrans.com';

    /**
     * Sandbox base URL for Snap API.
     */
    const SNAP_SANDBOX_BASE_URL = 'https://app.sandbox.midtrans.com/snap/v1';

    /**
     * Production base URL for Snap API.
     */
    const SNAP_PRODUCTION_BASE_URL = 'https://app.midtrans.com/snap/v1';

    /**
     * Get the base URL for Midtrans API.
     * Depends on the environment mode ($isProduction).
     *
     * @return string Midtrans API URL
     */
    public static function getBaseUrl()
    {
        return self::$isProduction ? self::PRODUCTION_BASE_URL : self::SANDBOX_BASE_URL;
    }

    /**
     * Get the base URL for Snap API.
     * Depends on the environment mode ($isProduction).
     *
     * @return string Snap API URL
     */
    public static function getSnapBaseUrl()
    {
        return self::$isProduction ? self::SNAP_PRODUCTION_BASE_URL : self::SNAP_SANDBOX_BASE_URL;
    }
}

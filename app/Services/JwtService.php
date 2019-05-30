<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Carbon\Carbon;

/**
 * @property \Monolog\Logger log
 */

class JwtService
{
    private $id = null;
    private $role = null;
    private $issuer = null;
    private $secret = null;
    private $duration = 3600;

    public function __construct($secret, $issuer, $duration, $log)
    {
        $this->secret = $secret;
        $this->issuer = $issuer;
        $this->duration = $duration;
        $this->log = $log;
    }

    public function id()
    {
        return $this->id;
    }

    public function role()
    {
        return $this->role;
    }

    public function issuer()
    {
        return $this->issuer;
    }

    public function parseToken($token)
    {
        try {
            $payload = JWT::decode($token, $this->secret, array('HS512'));

            if(!isset($payload->iss) || $payload->iss != $this->issuer) {
                $this->log->error("JWT parse fail: issuer invalid");
                return false;
            }

            $this->id = $payload->sub;
            $this->role = $payload->role;
            $this->issuer = $payload->iss;

            return true;
        } catch (\Exception $e) {
            // Ignore as invalid token
        }

        return false;
    }

    public function createNewToken($id, $role)
    {
        $now = Carbon::now();

        $payload = [
            'iss' => $this->issuer,
            'sub' => $id,
            'role' => $role,
            'iat' => $now->timestamp,
            'exp' => $now->addSeconds($this->duration)->timestamp
        ];

        return JWT::encode($payload, $this->secret);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function aesEncrypt(int $ticketId): string
    {
        $cipher = "aes-256-cbc";
        $encryption_key = "iI6IkJDeDRCY0xueHYxU2dwWUNaMXNkSlE9PSIsInZhbHVlIjoiclRmcnd4MElob"; // Remplacez par une clé secrète forte de votre choix
        $iv = "eventtoguestsapp";

        return openssl_encrypt($ticketId, $cipher, $encryption_key, 0, $iv);
    }

    public function aesDecrypt(string $encrypted): ?int
    {
        $cipher = "aes-256-cbc";
        $encryption_key = "iI6IkJDeDRCY0xueHYxU2dwWUNaMXNkSlE9PSIsInZhbHVlIjoiclRmcnd4MElob"; // Remplacez par la même clé que celle utilisée pour l'encryptage
        $iv = "eventtoguestsapp";

        $decrypted = openssl_decrypt($encrypted, $cipher, $encryption_key, 0, $iv);

        // Vérifiez si le déchiffrement a réussi
        if ($decrypted === false) {
            return null;
        }

        return (int) $decrypted;
    }

}

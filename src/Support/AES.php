<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: lmh <lmh@weiyian.com>
 * Date: 2021/10/18
 * Time: 下午8:34
 */

namespace Lmh\Payeco\Support;


class AES
{
    /**
     * @var string
     */
    protected $key;

    /**
     * AES constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * 数据加密 3des
     * @param string $plaintext
     * @return string
     * @author lmh
     */
    public function encrypt(string $plaintext): string
    {
        $plaintext = $this->pkcs5Pad($plaintext, 8);
        if (strlen($plaintext) % 8) {
            $plaintext = str_pad($plaintext,
                strlen($plaintext) + 8 - strlen($plaintext) % 8, "\0");
        }
        $ciphertext = openssl_encrypt($plaintext, "DES-EDE3", $this->key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING);
        return base64_encode($ciphertext);
    }

    /**
     * 数据解密
     * @param string $data
     * @return string
     * @author lmh
     */
    public function decrypt(string $data): string
    {
        $data = base64_decode($data);
        $plaintext = openssl_decrypt($data, "DES-EDE3", $this->key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING);
        return $this->pkcs5Unpacked($plaintext);
    }

    /**
     * @param string $text
     * @param int $blockSize
     * @return string
     * @author lmh
     */
    public function pkcs5Pad(string $text, int $blockSize): string
    {
        $pad = $blockSize - (strlen($text) % $blockSize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * @param string $text
     * @return string
     * @author lmh
     */
    public function pkcs5Unpacked(string $text): string
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) {
            return '';
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return '';
        }
        return substr($text, 0, -1 * $pad);
    }

    /**
     * 数据加密
     * @param $input
     * @param string $otherKey
     * @return string
     * @author lmh
     */
    public function encrypt1($input, $otherKey = "")
    {
        $size = @mcrypt_get_block_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
        $input = $this->pkcs5Pad($input, $size);
        $key = str_pad(($otherKey ? $otherKey : $this->key), 24, '0');
        $td = @mcrypt_module_open(MCRYPT_3DES, '', 'ecb', '');
        $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        @mcrypt_generic_init($td, $key, $iv);
        $data = @mcrypt_generic($td, $input);
        @mcrypt_generic_deinit($td);
        @mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    /**
     * 数据解密
     * @param $encrypted
     * @param string $otherKey
     * @return false|string
     * @author lmh
     */
    public function decrypt1($encrypted, $otherKey = "")
    {
        $encrypted = base64_decode($encrypted);
        $key = str_pad(($otherKey ? $otherKey : $this->key), 24, '0');
        $td = @mcrypt_module_open(MCRYPT_3DES, '', 'ecb', '');
        $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        $ks = @mcrypt_enc_get_key_size($td);
        @mcrypt_generic_init($td, $key, $iv);
        $decrypted = @mdecrypt_generic($td, $encrypted);
        @mcrypt_generic_deinit($td);
        @mcrypt_module_close($td);
        $y = $this->pkcs5Unpacked($decrypted);
        return $y;
    }

}
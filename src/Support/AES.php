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
            $plaintext = str_pad($plaintext, strlen($plaintext) + 8 - strlen($plaintext) % 8, "\0");
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
}
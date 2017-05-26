<?php

namespace MobileLocation\Src;

/**
 * Created by PhpStorm.
 * User: jesusslim
 * Date: 2017/5/26
 * Time: 上午10:43
 */
class MobileLocation
{

    private $p = null;
    private $size = 0;

    public function __construct($filename = "phone.dat") {
        $this->p = fopen(dirname(__FILE__).'/'.$filename, 'r');
        $this->size = filesize(dirname(__FILE__).'/'.$filename);
    }

    public function getLocation($phone)
    {
        if(!preg_match("/^1[34578]{1}\d{9}$/",$phone)){
            throw new \Exception('Invalid phone number.');
        }
        $pre = substr($phone, 0, 7);
        fseek($this->p, 4);
        $offset = fread($this->p, 4);
        $start = implode('', unpack('L', $offset));
        $total = ($this->size - $start)/9;
        $left = 0;
        $right = $total;
        while ($left < $right - 1) {
            $position = $left + intval(($right - $left)/2);
            fseek($this->p, ($position*9) + $start);
            $hit = implode('', unpack('L', fread($this->p, 4)));
            if ($hit < $pre) {
                $left = $position;
            } elseif ($hit > $pre) {
                $right = $position;
            } else {
                fseek($this->p, ($position*9+4) + $start);
                $index = unpack('Lidx_pos/ctype', fread($this->p, 5));
                $pos = $index['idx_pos'];
                fseek($this->p, $pos);
                $r = '';
                while (($tmp = fread($this->p, 1)) != chr(0)) {
                    $r .= $tmp;
                }
                $arr = explode('|', $r);
                return [
                    'province' => $arr[0],
                    'city' => $arr[1]
                ];
                break;
            }
        }
        throw new \Exception('Phone number not found.');
    }

    public function __destruct()
    {
        fclose($this->p);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24/05/2018
 * Time: 22:38
 */

namespace App\Enum;

class FuncionarioStatusEnum
{
    const STATUS_ATIVO = 'A';
    const STATUS_EXONERADO = 'E';
    public static function getStatus()
    {
        return [
            self::STATUS_ATIVO => 'Ativo',
            self::STATUS_EXONERADO =>'Exonerado'
        ];
    }
}
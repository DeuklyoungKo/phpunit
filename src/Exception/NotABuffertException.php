<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-03-10
 * Time: 오전 12:02
 */

namespace App\Exception;


class NotABuffertException extends \Exception
{
    protected $message = 'Please do not mix the carnivorous and non-carnivorous dinosaurs.';
}
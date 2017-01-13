<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 13/01/17
 * Time: 12:13
 */

namespace adminBundle\Service;


class UnlinkService
{
    private $uploadDir;

    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function remove($file)
    {
        unlink($this->uploadDir . $file);
    }
}
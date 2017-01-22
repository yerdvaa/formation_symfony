<?php

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
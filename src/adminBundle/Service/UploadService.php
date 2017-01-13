<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 12/01/17
 * Time: 14:15
 */

namespace adminBundle\Service;


use adminBundle\Service\Utils\StringService;

class UploadService
{
    private $stringUtilsService;
    private $uploadDir;

    public function __construct(StringService $stringUtilsService, $uploadDir)
    {
        $this->stringUtilsService = $stringUtilsService;
        $this->uploadDir = $uploadDir;
    }

    public function upload($image)
    {
        $fileName = $this->stringUtilsService->generateUniqId(). '.' . $image->guessExtension();
        $image->move($this->uploadDir , $fileName);
        return $fileName;
    }
}
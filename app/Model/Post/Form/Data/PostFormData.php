<?php declare(strict_types = 1);

namespace App\Model\Post\Form\Data;

class PostFormData
{
    public function __construct(
        public string $title,
        public string $perex,
        public string $content,
    ) 
    {
    }
}
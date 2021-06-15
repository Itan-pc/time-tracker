<?php


namespace App\Service;


use Symfony\Component\Form\FormInterface;

interface FormErrorService
{
    /**
     * Get form errors
     *
     * @param FormInterface $form
     * @return array
     */
    public function getFormErrors(FormInterface $form) : array;
}
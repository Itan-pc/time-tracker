<?php


namespace App\Service;


use Symfony\Component\Form\FormInterface;

class FormError implements FormErrorService
{
    /**
     * Get form errors
     *
     * @param FormInterface $form
     * @return array
     */
    public function getFormErrors(FormInterface $form) : array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            if ($form->isRoot()) {
                $errors['form'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getFormErrors($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }
}
<?php
namespace MauticPlugin\AcmeSkeletonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class TestActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('note', TextType::class, [
            'label'    => 'Note (optional)',
            'required' => false,
            'attr'     => ['placeholder' => 'Un texto de prueba'],
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'skeleton_test_action';
    }
}

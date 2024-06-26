<?php

namespace App\Form;

use App\Entity\Subsidiary;
use App\Entity\Transaction;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateTransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('account_id', IntegerType::class, [
                'mapped' => false,
            ])
            ->add('amount')
            ->add('description')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Retiro' => 'R',
                    'Depósito' => 'D',
                ],
            ])
            ->add('Procesar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}

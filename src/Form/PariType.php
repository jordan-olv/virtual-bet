<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Pari;
use App\Entity\Rencontre;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PariType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
            ->add('rencontre', EntityType::class, [
                'class' => Rencontre::class,
'choice_label' => 'id',
            ])
            ->add('EquipeChoix', EntityType::class, [
                'class' => Equipe::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pari::class,
        ]);
    }
}

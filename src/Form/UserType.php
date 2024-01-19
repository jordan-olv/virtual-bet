<?php

namespace App\Form;

use App\Entity\DownloadedFiles;
use App\Entity\User;
use App\Entity\UserStats;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('image', EntityType::class, [
                'class' => DownloadedFiles::class,
'choice_label' => 'id',
            ])
            ->add('userStats', EntityType::class, [
                'class' => UserStats::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Coin;
use App\Entity\SignalFutur;
use App\Entity\SignalSpot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SignalSpotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('coin', EntityType::class, [
                'label' => 'Coin<span style="color:red">*</span>',
                'label_html' => true,
                'class' => Coin::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('entry', NumberType::class,[
                'label' => 'Entry<span style="color:red">*</span>',
                'label_html' => true,
                'attr' => ['class'=>'form-control mb-2'],
            ])
            ->add('stop', NumberType::class,[
                'label' => 'Stop<span style="color:red">*</span>',
                'label_html' => true,
                'attr' => ['class'=>'form-control mb-2'],
            ])
            ->add('isPublic', CheckboxType::class, [
                'label' => 'Gratuit',
                'attr' => ['class' => 'form-check-input mb-2'],
                'label_attr' => ['class' => 'form-check-label mr-4'],
                'required' => false,
            ])
           
            ->add('submit', SubmitType::class, [
                'label'=>'Valider',
                'attr' => ['class'=>'btn btn-primary','style'=>'float:right']
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SignalSpot::class,
        ]);
    }
}
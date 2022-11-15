<?php

namespace App\Form;

use App\Entity\Hobby;
use App\Entity\Job;
use App\Entity\Person;
use App\Entity\Profil;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('name')
            ->add('age')
            ->add('job')
            ->add('no')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('profil', EntityType::class, [
                'expanded' => true,
                'multiple' => false,
                'class' => Profil::class,
            ])
            ->add('hobbies', EntityType::class, [
                'expanded' => true,
                'multiple' => true,
                'class' => Hobby::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.designation', 'ASC');
                },
                'choice_label' => 'designation'
            ])
            ->add('image', FileType::class, [
                'label' => 'Profil Image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('personJob',EntityType::class, [
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'class' => Job::class,
                'attr' => [
                    'class' => 'select2'
                ]
            ])
            ->add('Valider',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}

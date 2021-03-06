<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Faction;
use App\Entity\Rarity;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('health', IntegerType::class)
            ->add('attack', IntegerType::class)
            ->add('mana', IntegerType::class)
            ->add('faction',EntityType::class,[
                "class" => Faction::class,
                "choice_label" => "name"
            ])
            ->add('rarity',EntityType::class,[
                "class" => Rarity::class,
                "choice_label" => "name"
            ])
            ->add("image", FileType::class,[
                "data_class" => null,
                "constraints" => [
                    new File([
                        "mimeTypes" => "image/*",
                        'mimeTypesMessage' => "Le fichier n'est pas une images",
                    ])
                ],
                "required" => false

            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}

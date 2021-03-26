<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'attr' => ['placeholder' => 'Tapez le nom du produit']
            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Description courte',
                'attr' => ['placeholder' => 'Tapez une description assez courte mais parlante pour le visiteur']
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix du produit',
                'divisor' => 100,
                'attr' => ['placeholder' => 'Tapez le prix du produit en euros']
            ])
            ->add('mainPicture', UrlType::class, [
                'label' => 'Photo du produit',
                'attr' => ['placeholder' => 'Tapez une URL d\'image']
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégories',
                'placeholder' => 'Choisir une catégorie',
                'class' => Category::class,
                'choice_label' => function (Category $category) {
                    return strtoupper($category->getName());
                },
            ]);

//        $builder->get('price')->addModelTransformer(new CentimesTransformer());

//        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
//            /** @var Product $product */
//            $product = $event->getData();
//
//            if ($product->getPrice() !== null) {
//                $product->setPrice($product->getPrice() * 100);
//            }
//        });

//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
//            /** @var Product $product */
//            $product = $event->getData();
//
//            if ($product->getPrice() !== null) {
//                $product->setPrice($product->getPrice() / 100);
//            }

//            if ($product->getId() === null) {
//                $form = $event->getForm();
//
//                $form->add('category', EntityType::class, [
//                    'label' => 'Catégories',
//                    'attr' => ['class' => 'form-control'],
//                    'placeholder' => 'Choisir une catégorie',
//                    'class' => Category::class,
//                    'choice_label' => function (Category $category) {
//                        return strtoupper($category->getName());
//                    },
//                ]);
//            }
//        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

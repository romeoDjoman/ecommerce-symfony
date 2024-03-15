<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('image')->setBasePath('assets/upload/products/')
                                    ->setUploadDir('public/assets/upload/products/')
                                    ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextField::new('nameProduct'),
            SlugField::new('slug')->setTargetFieldName('nameProduct'),
            TextareaField::new('description'),
            TextareaField::new('moreInformations')->hideOnIndex(),
            MoneyField::new('price')->setCurrency('EUR'),
            IntegerField::new('quantity'),
            TextField::new('tags'),
            BooleanField::new('isBest', 'Le meilleur'),
            BooleanField::new('isNew', 'Nouveauté'),
            BooleanField::new('isFeatured', 'Moderne'),
            BooleanField::new('isSpecialOffer', 'Offre spéciale'),
            AssociationField::new('category'),
            DateTimeField::new('createdAt')->hideOnForm(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $product = new $entityFqcn();
        $product->setCreateAt(new \DateTime());

        return $product;
    }
    
}

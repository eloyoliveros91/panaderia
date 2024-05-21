<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Producto;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('admin@checkin.com');
        $user1->setPassword('$2y$13$PW79xqhGG7/9ZncDJXjVoOagw1aQpUSx21Xlx5.DrytZ4nIlyGRpG');
        $user1->setRoles(['ROLE_ADMIN']);
        $manager->persist($user1);

        $product1 = new Producto();
        $product1->setNombre('Baguette');
        $product1->setDescripcion('A classic French baguette');
        $product1->setPrecio(2.50);
        $product1->setDisponible(true);
        $manager->persist($product1);

        $product2 = new Producto();
        $product2->setNombre('Croissant');
        $product2->setDescripcion('A delicious buttery croissant');
        $product2->setPrecio(1.80);
        $product2->setDisponible(true);
        $manager->persist($product2);

        $product3 = new Producto();
        $product3->setNombre('Sourdough Bread');
        $product3->setDescripcion('Artisanal sourdough bread');
        $product3->setPrecio(3.20);
        $product3->setDisponible(true);
        $manager->persist($product3);

        // Guardar los cambios en la base de datos
        $manager->flush();
        // $manager->persist($product);

        $manager->flush();
    }
}

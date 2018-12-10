<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 26/11/18
 * Time: 16:54
 */

namespace App\DataFixtures;

use Faker;
use App\Service\Slugify;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $slugify = new Slugify();

        for ($i = 0; $i < 50; $i++) {
            $article = new Article();
            $article->setTitle(strtolower($faker->sentence()));
            $article->setContent($faker->text);
            $article->setSlug($slugify->generate($article->getTitle()));
            $manager->persist($article);
            $article->setCategory($this->getReference('categorie_' . rand(0, 3)));
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
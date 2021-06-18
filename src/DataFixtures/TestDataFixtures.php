<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\User;
use App\Entity\Date;
use App\Entity\Category;
use App\Entity\BlogPost;
use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TestDataFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
         $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $image = new Image();
        $image->setTitle("a nice image");
        $image->setAlt("alt of a nice image");
        $image->setPath("/images/page_header/_MG_9008-1.jpg");

        $manager->persist($image);

        /*
        for ($i=0; $i < 21; $i++) { 
            $image = new Image();
            $image->setTitle("a nice image");
            $image->setAlt("alt of a nice image");
            $image->setPath("/images/page_header/_MG_9008-1.jpg");

            $manager->persist($image);
        }*/

        $image1 = new Image();
        $image1->setTitle("a nice image");
        $image1->setAlt("alt of a nice image");
        $image1->setPath("/images/page_thumbnails/3boxes.jpg");

        $manager->persist($image1);
        
        $date = new Date();
        $date->setDate(new \DateTime());

        $manager->persist($date);        
        $user = new User();
        $user->setFirstName("Jean");
        $user->setLastName("DuPont");
        $user->setUsername("jeanDu");
        $user->setDisplayedNickName("j3an");
        $user->setEmail("jean@mail.com");
        $user->setBlogImage($image);
        $user->setRegistrationDate($date);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setProfilPic(uniqid("user_profil_pic_", true));
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'abcd'
        ));

        $manager->persist($user);

        $user1 = new User();
        $user1->setFirstName("Jack");
        $user1->setLastName("Skdj");
        $user1->setUsername("Jacky");
        $user1->setDisplayedNickName("J4CKY");
        $user1->setEmail("jack@jack.com");
        $user1->setBlogImage($image);
        $user1->setRoles(['ROLE_USER']);
        $user1->setRegistrationDate($date);
        $user1->setProfilPic(uniqid("user_profil_pic_", true));
        $user1->setPassword($this->passwordHasher->hashPassword(
            $user1,
            'abcd'
        ));

        $manager->persist($user1);


        $category = new Category();
        $category->setName("dev");
        $manager->persist($category);
        $category1 = new Category();
        $category1->setName("web");
        $manager->persist($category1);
        $category1 = new Category();
        $category1->setName("réseau");
        $manager->persist($category1);
        $category1 = new Category();
        $category1->setName("Systeme");
        $manager->persist($category1);
        $category1 = new Category();
        $category1->setName("Linux");
        $manager->persist($category1);
        $category1 = new Category();
        $category1->setName("Windows");
        $manager->persist($category1);
        $category1 = new Category();
        $category1->setName("C#");
        $manager->persist($category1);

        for ($i=0; $i < 11; $i++) { 
            $article = new Article();
            $article->setTitle("FileTeleport");
            $article->setDescription("a super file transfer app");
            $article->setContent('{"pageContent":[{"Type":"h","Content":"test"}]}');
            $article->setHeaderImage($image);
            $article->setPublicationDate($date);
            $article->setCategory($category);
            $article->setWriter($user);
            $article->setThumbnail($image1);
            $article->setPathTitle("new-fileteleport-update".uniqid("",true));
    
            $manager->persist($article);
        }

        for ($i=0; $i < 11; $i++) { 
            $blogPost = new BlogPost();
            $blogPost->setTitle("Yaaaa");
            $blogPost->setContent("saudfhésahdflsah lkjahslfk ghaskljdhhflkasfhas lgklasjhf kljashdkjkldfksdgkas hk jhsakldgfl hgaslkjdhiu lsa HDGJAHSG AJSDHGKSHF LK FHALIUSDGLASHDLFGASLIUHGLU lsaudfg liazsdfiu salifdh iuasdfilus aliuahsghlsiau hkjldsahgl uhsag kjashdg lukhasidlfia8ztrh ashglizas uhlksadfklu");
            $blogPost->setWriter($user);
            $blogPost->setCategory($category);
            $blogPost->setPublicationDate($date);
    
            $manager->persist($blogPost);
        }

        $blogPost = new BlogPost();
        $blogPost->setTitle("talking about web");
        $blogPost->setContent("uahslfh lasjdhf lkajhdgkl askjldhlka f ljadfasgd flasjhdfjgsjfgadfhasdf kbsdblkas gb safd jahsd kjsaf ajskdfh luuash iuhaéhgaslkghlasuh gljasdjfshfgjlsdldfg lkdsj lkaslasj glas ghlask hah");
        $blogPost->setWriter($user);
        $blogPost->setCategory($category1);
        $blogPost->setPublicationDate($date);

        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle("web");
        $blogPost->setContent("asdfgasgf asdf sadf as fasgasdg adsg uahslfh lasjdhf lkajhdgkl askjldhlka f ljadfasgd flasjhdfjgsjfgadfhasdf kbsdblkas gb safd jahsd kjsaf ajskdfh luuash iuhaéhgaslkghlasuh gljasdjfshfgjlsdldfg lkdsj lkaslasj glas ghlask hah");
        $blogPost->setWriter($user1);
        $blogPost->setCategory($category1);
        $blogPost->setPublicationDate($date);

        $manager->persist($blogPost);

        

        $manager->flush();
    }
}

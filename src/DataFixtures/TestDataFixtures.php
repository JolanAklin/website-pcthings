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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TestDataFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
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
        $user->setEmail("jean@mail.com");
        $user->setBlogImage($image);
        $user->setRegistrationDate($date);
        $user->setProfilPic("/images/profile_pictures/profile_pic_jean.jpg");
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'abcd'
        ));

        $manager->persist($user);

        $user1 = new User();
        $user1->setFirstName("Jack");
        $user1->setLastName("Skdj");
        $user1->setUsername("Jacky");
        $user1->setEmail("jack@skdj.com");
        $user1->setBlogImage($image);
        $user1->setRegistrationDate($date);
        $user1->setProfilPic("/images/profile_pictures/jack_profile_pic.jpg");
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword($this->passwordEncoder->encodePassword(
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

        $article = new Article();
        $article->setTitle("FileTeleport");
        $article->setDescription("a super file transfer app");
        $article->setContent("<h1>New Update</h1><p>éoasirfhasuhilah ilhasli hliuahgl hdklfghlka shglkahrgéuhaiuhg filuahlt guhahligéuaegiruésa hkjahskljg haklsjdhgklasjd fég hklahd klhaséjgh éaerh édjfhj ahkl hakjgh lahgiwhrpiu airghaskljgh lka gasfg fégo iargh lkdjsghoezgoiàser géodsfgeshé jghsgkhésjhgg éjsdfhgkljshroptz hjfglduertusdfglkjsdfklgjbsldkfghiuhtéph eurtp98t hliuer gsdg jsrlti hsldifis r0ehgoisdfgohsdig lirgihsdf hglksjrg iushdg sdh</p><p>hailuhgkashdlk ahigrhkajhl haliutziahgfiuahsdkfljat liueaiuas liutwililashl ghaliu rt</p><a href='https://github.com/JolanAklin/FileTeleporter' target='_blank'>fileteport</a><p>gliasgluashlti uéoi aligliuaséitz alghliueargliushdgkhsep8rtzh egrhlise rt</p>");
        $article->setHeaderImage($image);
        $article->setPublicationDate($date);
        $article->setCategory($category);
        $article->setWriter($user);
        $article->setThumbnail($image1);

        $manager->persist($article);

        $blogPost = new BlogPost();
        $blogPost->setTitle("Yaaaa");
        $blogPost->setContent("saudfhésahdflsah lkjahslfk ghaskljdhhflkasfhas lgklasjhf kljashdkjkldfksdgkas hk jhsakldgfl hgaslkjdhiu lsa HDGJAHSG AJSDHGKSHF LK FHALIUSDGLASHDLFGASLIUHGLU lsaudfg liazsdfiu salifdh iuasdfilus aliuahsghlsiau hkjldsahgl uhsag kjashdg lukhasidlfia8ztrh ashglizas uhlksadfklu");
        $blogPost->setWriter($user);
        $blogPost->setCategory($category);
        $blogPost->setPublicationDate($date);

        $manager->persist($blogPost);

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

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
        
        $date = new Date();
        $date->setDate(new \DateTime());

        $manager->persist($date);

        $user = new User();
        $user->setFirstName("Jean");
        $user->setLastName("DuPont");
        $user->setNickName("jeanDu");
        $user->setEmail("jean@mail.com");
        $user->setUuid("10");
        $user->setBlogImage($image);
        $user->setRegistrationDate($date);
        $user->setProfilPic("/images/profile_pictures/profile_pic_jean.jpg");
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'abcd'
        ));

        $manager->persist($user);


        $category = new Category();
        $category->setName("dev");

        $manager->persist($category);

        $article = new Article();
        $article->setTitle("FileTeleport");
        $article->setDescription("a super file transfer app");
        $article->setContent("éoasirfhasuhilah ilhasli hliuahgl hdklfghlka shglkahrgéuhaiuhg filuahlt guhahligéuaegirué hailuhgkashdlk ahigrhkajhl haliutziahgfiuahsdkfljat liueaiuas liutwililashl ghaliu rt gliasgluashlti uéoi aligliuaséitz alghliueargliushdgkhsep8rtzh egrhlise rt");
        $article->setHeaderImage($image);
        $article->setPublicationDate($date);
        $article->setCategory($category);
        $article->setWriter($user);

        $manager->persist($article);

        $blogPost = new BlogPost();
        $blogPost->setTitle("Yaaaa");
        $blogPost->setContent("saudfhésahdflsah lkjahslfk ghaskljdhhflkasfhas lgklasjhf kljashdkjkldfksdgkas hk jhsakldgfl hgaslkjdhiu lsa HDGJAHSG AJSDHGKSHF LK FHALIUSDGLASHDLFGASLIUHGLU lsaudfg liazsdfiu salifdh iuasdfilus aliuahsghlsiau hkjldsahgl uhsag kjashdg lukhasidlfia8ztrh ashglizas uhlksadfklu");
        $blogPost->setWriter($user);
        $blogPost->setCategory($category);
        $blogPost->setPublicationDate($date);

        $manager->persist($blogPost);

        

        $manager->flush();
    }
}

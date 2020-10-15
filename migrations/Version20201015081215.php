<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201015081215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, publication_date_id INT NOT NULL, category_id INT NOT NULL, header_image_id INT NOT NULL, writer_id INT NOT NULL, thumbnail_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, path_title VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_23A0E66DE54D0B5 (path_title), INDEX IDX_23A0E66B01EE057 (publication_date_id), INDEX IDX_23A0E6612469DE2 (category_id), INDEX IDX_23A0E668C782417 (header_image_id), INDEX IDX_23A0E661BC7E6B6 (writer_id), INDEX IDX_23A0E66FDFF2E92 (thumbnail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_post (id INT AUTO_INCREMENT NOT NULL, publication_date_id INT NOT NULL, category_id INT NOT NULL, writer_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_BA5AE01DB01EE057 (publication_date_id), INDEX IDX_BA5AE01D12469DE2 (category_id), INDEX IDX_BA5AE01D1BC7E6B6 (writer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, registration_date_id INT NOT NULL, blog_image_id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, profil_pic VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649F8E663CD (registration_date_id), INDEX IDX_8D93D64949F8014A (blog_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66B01EE057 FOREIGN KEY (publication_date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E668C782417 FOREIGN KEY (header_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E661BC7E6B6 FOREIGN KEY (writer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FDFF2E92 FOREIGN KEY (thumbnail_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01DB01EE057 FOREIGN KEY (publication_date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01D1BC7E6B6 FOREIGN KEY (writer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F8E663CD FOREIGN KEY (registration_date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64949F8014A FOREIGN KEY (blog_image_id) REFERENCES image (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01D12469DE2');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66B01EE057');
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01DB01EE057');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F8E663CD');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E668C782417');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66FDFF2E92');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64949F8014A');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E661BC7E6B6');
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01D1BC7E6B6');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE blog_post');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE date');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE user');
    }
}

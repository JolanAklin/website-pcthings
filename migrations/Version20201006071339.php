<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201006071339 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD blog_image_id INT NOT NULL, DROP blog_image');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64949F8014A FOREIGN KEY (blog_image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64949F8014A ON user (blog_image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64949F8014A');
        $this->addSql('DROP INDEX IDX_8D93D64949F8014A ON user');
        $this->addSql('ALTER TABLE user ADD blog_image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP blog_image_id');
    }
}
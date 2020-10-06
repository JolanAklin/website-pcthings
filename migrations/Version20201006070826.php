<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201006070826 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64949F8014A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F8E663CD');
        $this->addSql('DROP INDEX IDX_8D93D64949F8014A ON user');
        $this->addSql('DROP INDEX IDX_8D93D649F8E663CD ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649D17F50A6 ON user');
        $this->addSql('ALTER TABLE user ADD blog_image VARCHAR(255) NOT NULL, DROP registration_date_id, DROP blog_image_id, DROP nick_name, CHANGE first_name first_name VARCHAR(100) NOT NULL, CHANGE last_name last_name VARCHAR(100) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE uuid username VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user ADD registration_date_id INT NOT NULL, ADD blog_image_id INT DEFAULT NULL, ADD nick_name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP blog_image, CHANGE first_name first_name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE username uuid VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64949F8014A FOREIGN KEY (blog_image_id) REFERENCES image (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F8E663CD FOREIGN KEY (registration_date_id) REFERENCES date (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D64949F8014A ON user (blog_image_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F8E663CD ON user (registration_date_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D17F50A6 ON user (uuid)');
    }
}

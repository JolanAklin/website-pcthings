<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210702094005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article RENAME INDEX search_index TO search_index_articles');
        $this->addSql('ALTER TABLE blog_post ADD content_indexable LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE FULLTEXT INDEX search_index_blogpost ON blog_post (title, writer_id, content_indexable)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article RENAME INDEX search_index_articles TO search_index');
        $this->addSql('DROP INDEX search_index_blogpost ON blog_post');
        $this->addSql('ALTER TABLE blog_post DROP content_indexable');
    }
}

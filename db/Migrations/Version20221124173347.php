<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221124173347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE posts (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, perex VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_885DBAFA989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts_ratings (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', post_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', kind VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_61D61EA24B89032C (post_id), INDEX IDX_61D61EA2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(32) NOT NULL, slug VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E9989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE posts_ratings ADD CONSTRAINT FK_61D61EA24B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE posts_ratings ADD CONSTRAINT FK_61D61EA2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts_ratings DROP FOREIGN KEY FK_61D61EA24B89032C');
        $this->addSql('ALTER TABLE posts_ratings DROP FOREIGN KEY FK_61D61EA2A76ED395');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE posts_ratings');
        $this->addSql('DROP TABLE users');
    }
}

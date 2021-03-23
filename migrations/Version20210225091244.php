<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225091244 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_C53D045FB281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick (id INT AUTO_INCREMENT NOT NULL, trick_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D8F0A91E5E237E06 (name), UNIQUE INDEX UNIQ_D8F0A91E989D9B62 (slug), INDEX IDX_D8F0A91E9C71FA8B (trick_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_639F9D7E5E237E06 (name), UNIQUE INDEX UNIQ_639F9D7E989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, trick_id INT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F7292B34A76ED395 (user_id), INDEX IDX_F7292B34B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, validated TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_reset_password_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_FB0D4DBAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, youtube_id VARCHAR(255) NOT NULL, INDEX IDX_7CC7DA2CB281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E9C71FA8B FOREIGN KEY (trick_category_id) REFERENCES trick_category (id)');
        $this->addSql('ALTER TABLE trick_comment ADD CONSTRAINT FK_F7292B34A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trick_comment ADD CONSTRAINT FK_F7292B34B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE user_reset_password_token ADD CONSTRAINT FK_FB0D4DBAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FB281BE2E');
        $this->addSql('ALTER TABLE trick_comment DROP FOREIGN KEY FK_F7292B34B281BE2E');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CB281BE2E');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E9C71FA8B');
        $this->addSql('ALTER TABLE trick_comment DROP FOREIGN KEY FK_F7292B34A76ED395');
        $this->addSql('ALTER TABLE user_reset_password_token DROP FOREIGN KEY FK_FB0D4DBAA76ED395');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE trick');
        $this->addSql('DROP TABLE trick_category');
        $this->addSql('DROP TABLE trick_comment');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_reset_password_token');
        $this->addSql('DROP TABLE video');
    }
}

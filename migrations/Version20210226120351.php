<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226120351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_validation_token DROP FOREIGN KEY FK_CA31E6F59D86650F');
        $this->addSql('DROP INDEX UNIQ_CA31E6F59D86650F ON user_validation_token');
        $this->addSql('ALTER TABLE user_validation_token DROP created_at, CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_validation_token ADD CONSTRAINT FK_CA31E6F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CA31E6F5A76ED395 ON user_validation_token (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_validation_token DROP FOREIGN KEY FK_CA31E6F5A76ED395');
        $this->addSql('DROP INDEX UNIQ_CA31E6F5A76ED395 ON user_validation_token');
        $this->addSql('ALTER TABLE user_validation_token ADD created_at DATETIME NOT NULL, CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_validation_token ADD CONSTRAINT FK_CA31E6F59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CA31E6F59D86650F ON user_validation_token (user_id_id)');
    }
}

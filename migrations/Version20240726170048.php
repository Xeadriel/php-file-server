<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726170048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file ADD creation_date DATETIME NOT NULL, ADD last_modified_date_time DATETIME NOT NULL, DROP creationDateTime, DROP lastModifiedDateTime');
        $this->addSql('ALTER TABLE user CHANGE isVerified is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file ADD creationDateTime DATETIME NOT NULL, ADD lastModifiedDateTime DATETIME NOT NULL, DROP creation_date, DROP last_modified_date_time');
        $this->addSql('ALTER TABLE user CHANGE is_verified isVerified TINYINT(1) NOT NULL');
    }
}

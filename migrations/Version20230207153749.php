<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207153749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE continents (id INT AUTO_INCREMENT NOT NULL, continentdid_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_42D13510888641E5 (continentdid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, capital VARCHAR(255) NOT NULL, population INT NOT NULL, monnay VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE continents ADD CONSTRAINT FK_42D13510888641E5 FOREIGN KEY (continentdid_id) REFERENCES countries (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE continents DROP FOREIGN KEY FK_42D13510888641E5');
        $this->addSql('DROP TABLE continents');
        $this->addSql('DROP TABLE countries');
    }
}

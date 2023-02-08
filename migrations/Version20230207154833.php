<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207154833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE countries ADD continentid_id INT NOT NULL');
        $this->addSql('ALTER TABLE countries ADD CONSTRAINT FK_5D66EBAD5418884F FOREIGN KEY (continentid_id) REFERENCES continents (id)');
        $this->addSql('CREATE INDEX IDX_5D66EBAD5418884F ON countries (continentid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE countries DROP FOREIGN KEY FK_5D66EBAD5418884F');
        $this->addSql('DROP INDEX IDX_5D66EBAD5418884F ON countries');
        $this->addSql('ALTER TABLE countries DROP continentid_id');
    }
}

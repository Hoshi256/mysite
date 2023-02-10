<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210082828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacance ADD pays_id INT NOT NULL');
        $this->addSql('ALTER TABLE vacance ADD CONSTRAINT FK_BD3530F2A6E44244 FOREIGN KEY (pays_id) REFERENCES vacance (id)');
        $this->addSql('CREATE INDEX IDX_BD3530F2A6E44244 ON vacance (pays_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacance DROP FOREIGN KEY FK_BD3530F2A6E44244');
        $this->addSql('DROP INDEX IDX_BD3530F2A6E44244 ON vacance');
        $this->addSql('ALTER TABLE vacance DROP pays_id');
    }
}

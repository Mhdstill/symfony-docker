<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230225153036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE signal_futur ADD coin_id INT NOT NULL');
        $this->addSql('ALTER TABLE signal_futur ADD CONSTRAINT FK_FCA5CB1384BBDA7 FOREIGN KEY (coin_id) REFERENCES coin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FCA5CB1384BBDA7 ON signal_futur (coin_id)');
        $this->addSql('ALTER TABLE signal_spot ADD coin_id INT NOT NULL');
        $this->addSql('ALTER TABLE signal_spot ADD CONSTRAINT FK_AC14814584BBDA7 FOREIGN KEY (coin_id) REFERENCES coin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AC14814584BBDA7 ON signal_spot (coin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE signal_futur DROP CONSTRAINT FK_FCA5CB1384BBDA7');
        $this->addSql('DROP INDEX IDX_FCA5CB1384BBDA7');
        $this->addSql('ALTER TABLE signal_futur DROP coin_id');
        $this->addSql('ALTER TABLE signal_spot DROP CONSTRAINT FK_AC14814584BBDA7');
        $this->addSql('DROP INDEX IDX_AC14814584BBDA7');
        $this->addSql('ALTER TABLE signal_spot DROP coin_id');
    }
}

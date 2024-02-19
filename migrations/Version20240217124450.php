<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217124450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_BDD98E909B50270B ON playeruser');
        $this->addSql('ALTER TABLE playeruser ADD username VARCHAR(255) NOT NULL, ADD maingame VARCHAR(255) NOT NULL, ADD proll VARCHAR(255) NOT NULL, ADD point INT DEFAULT NULL, ADD pambition VARCHAR(255) NOT NULL, ADD lvl INT DEFAULT NULL, CHANGE pemail pemail VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playeruser DROP username, DROP maingame, DROP proll, DROP point, DROP pambition, DROP lvl, CHANGE pemail pemail VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDD98E909B50270B ON playeruser (pemail)');
    }
}

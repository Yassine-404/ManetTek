<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219013135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playeruser ADD idpmatch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE playeruser ADD CONSTRAINT FK_BDD98E90272D0D31 FOREIGN KEY (idpmatch_id) REFERENCES pmatch (id)');
        $this->addSql('CREATE INDEX IDX_BDD98E90272D0D31 ON playeruser (idpmatch_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playeruser DROP FOREIGN KEY FK_BDD98E90272D0D31');
        $this->addSql('DROP INDEX IDX_BDD98E90272D0D31 ON playeruser');
        $this->addSql('ALTER TABLE playeruser DROP idpmatch_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218160632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A652A0C23F8');
        $this->addSql('DROP INDEX IDX_98197A652A0C23F8 ON player');
        $this->addSql('ALTER TABLE player DROP matchistory_id');
        $this->addSql('ALTER TABLE playeruser ADD matchistory_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE playeruser ADD CONSTRAINT FK_BDD98E902A0C23F8 FOREIGN KEY (matchistory_id) REFERENCES matchistory (id)');
        $this->addSql('CREATE INDEX IDX_BDD98E902A0C23F8 ON playeruser (matchistory_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player ADD matchistory_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A652A0C23F8 FOREIGN KEY (matchistory_id) REFERENCES matchistory (id)');
        $this->addSql('CREATE INDEX IDX_98197A652A0C23F8 ON player (matchistory_id)');
        $this->addSql('ALTER TABLE playeruser DROP FOREIGN KEY FK_BDD98E902A0C23F8');
        $this->addSql('DROP INDEX IDX_BDD98E902A0C23F8 ON playeruser');
        $this->addSql('ALTER TABLE playeruser DROP matchistory_id');
    }
}

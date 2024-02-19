<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218160157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matchistory (id INT AUTO_INCREMENT NOT NULL, idmatch_id INT DEFAULT NULL, result VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_871F9F29806BE4DB (idmatch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matchistory ADD CONSTRAINT FK_871F9F29806BE4DB FOREIGN KEY (idmatch_id) REFERENCES pmatch (id)');
        $this->addSql('ALTER TABLE player ADD matchistory_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A652A0C23F8 FOREIGN KEY (matchistory_id) REFERENCES matchistory (id)');
        $this->addSql('CREATE INDEX IDX_98197A652A0C23F8 ON player (matchistory_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A652A0C23F8');
        $this->addSql('ALTER TABLE matchistory DROP FOREIGN KEY FK_871F9F29806BE4DB');
        $this->addSql('DROP TABLE matchistory');
        $this->addSql('DROP INDEX IDX_98197A652A0C23F8 ON player');
        $this->addSql('ALTER TABLE player DROP matchistory_id');
    }
}

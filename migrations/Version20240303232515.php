<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303232515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, adress VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, zipcode INT NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, reset_token_expires_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D6496C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE jeux CHANGE imagej imagej VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projectweb CHANGE nom_p nom_p VARCHAR(255) DEFAULT NULL, CHANGE image_p image_p VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE jeux CHANGE imagej imagej VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE projectweb CHANGE nom_p nom_p VARCHAR(255) DEFAULT \'NULL\', CHANGE image_p image_p VARCHAR(255) DEFAULT \'NULL\'');
    }
}

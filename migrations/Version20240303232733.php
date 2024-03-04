<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303232733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, entity_type VARCHAR(255) NOT NULL, entity_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE jeux (id INT AUTO_INCREMENT NOT NULL, nomj VARCHAR(255) NOT NULL, prixj NUMERIC(10, 0) NOT NULL, descj VARCHAR(255) NOT NULL, stockj INT NOT NULL, imagej VARCHAR(255) DEFAULT NULL, total_rating INT NOT NULL, average_rating DOUBLE PRECISION NOT NULL, categorie_id INT NOT NULL, INDEX IDX_3755B50DBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE projectweb (id INT AUTO_INCREMENT NOT NULL, nom_p VARCHAR(255) DEFAULT NULL, prix_p NUMERIC(10, 0) NOT NULL, desc_p VARCHAR(255) NOT NULL, stock_p INT NOT NULL, image_p VARCHAR(255) DEFAULT NULL, total_rating INT NOT NULL, average_rating DOUBLE PRECISION NOT NULL, categorie_id INT DEFAULT NULL, INDEX IDX_65E5E2FDBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, adress VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, zipcode INT NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, reset_token_expires_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D6496C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50DBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE projectweb ADD CONSTRAINT FK_65E5E2FDBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50DBCF5E72D');
        $this->addSql('ALTER TABLE projectweb DROP FOREIGN KEY FK_65E5E2FDBCF5E72D');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE jeux');
        $this->addSql('DROP TABLE projectweb');
        $this->addSql('DROP TABLE user');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230312180226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact_client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, adresse2 VARCHAR(255) DEFAULT NULL, code_postal INT DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, telephone1 VARCHAR(255) DEFAULT NULL, telephone2 VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture DROP reference');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contact_client');
        $this->addSql('ALTER TABLE facture ADD reference VARCHAR(40) NOT NULL');
    }
}

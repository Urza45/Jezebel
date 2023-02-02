<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125160637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE society (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, cp INT DEFAULT NULL, town VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E037FB9F2563 FOREIGN KEY (id_testeur) REFERENCES users (id)');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E0376D43C268 FOREIGN KEY (id_formateur) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE society');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E037FB9F2563');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E0376D43C268');
    }
}

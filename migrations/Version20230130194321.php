<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230130194321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parameters_society (id INT AUTO_INCREMENT NOT NULL, code_dossier VARCHAR(255) NOT NULL, inc_code_dossier INT NOT NULL, code_facture VARCHAR(255) NOT NULL, inc_code_facture INT NOT NULL, code_convention VARCHAR(255) NOT NULL, inc_code_convention INT NOT NULL, code_devis VARCHAR(255) NOT NULL, inc_code_devis INT NOT NULL, code_convocation VARCHAR(255) NOT NULL, inc_code_convocation INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE parameters_society');
    }
}

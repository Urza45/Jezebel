<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221161838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, pts INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme_theorique (id INT AUTO_INCREMENT NOT NULL, norme_id_id INT DEFAULT NULL, intitule VARCHAR(255) DEFAULT NULL, ordre INT NOT NULL, photo VARCHAR(255) DEFAULT NULL, pts INT NOT NULL, INDEX IDX_5938281C4142BD3C (norme_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE theme_theorique ADD CONSTRAINT FK_5938281C4142BD3C FOREIGN KEY (norme_id_id) REFERENCES norme (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE theme_theorique DROP FOREIGN KEY FK_5938281C4142BD3C');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE theme_theorique');
    }
}

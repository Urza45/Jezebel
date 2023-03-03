<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221164644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sous_theme (id INT AUTO_INCREMENT NOT NULL, theme_theorique_id INT DEFAULT NULL, intitule VARCHAR(255) DEFAULT NULL, ordre INT NOT NULL, photo VARCHAR(255) DEFAULT NULL, INDEX IDX_E891E7ED6228949 (theme_theorique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sous_theme ADD CONSTRAINT FK_E891E7ED6228949 FOREIGN KEY (theme_theorique_id) REFERENCES theme_theorique (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sous_theme DROP FOREIGN KEY FK_E891E7ED6228949');
        $this->addSql('DROP TABLE sous_theme');
    }
}

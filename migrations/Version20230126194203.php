<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126194203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE normes_autorisees (id INT AUTO_INCREMENT NOT NULL, society_id INT DEFAULT NULL, normes_id INT DEFAULT NULL, INDEX IDX_971B79E5E6389D24 (society_id), INDEX IDX_971B79E55A6CA64 (normes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE normes_autorisees ADD CONSTRAINT FK_971B79E5E6389D24 FOREIGN KEY (society_id) REFERENCES society (id)');
        $this->addSql('ALTER TABLE normes_autorisees ADD CONSTRAINT FK_971B79E55A6CA64 FOREIGN KEY (normes_id) REFERENCES norme (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE normes_autorisees DROP FOREIGN KEY FK_971B79E5E6389D24');
        $this->addSql('ALTER TABLE normes_autorisees DROP FOREIGN KEY FK_971B79E55A6CA64');
        $this->addSql('DROP TABLE normes_autorisees');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230312180551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_client ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_client ADD CONSTRAINT FK_57D633D419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_57D633D419EB6921 ON contact_client (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_client DROP FOREIGN KEY FK_57D633D419EB6921');
        $this->addSql('DROP INDEX IDX_57D633D419EB6921 ON contact_client');
        $this->addSql('ALTER TABLE contact_client DROP client_id');
    }
}

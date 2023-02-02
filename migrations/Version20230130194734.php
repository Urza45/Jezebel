<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230130194734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parameters_society ADD id_society_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parameters_society ADD CONSTRAINT FK_F09B2CA443B21DF3 FOREIGN KEY (id_society_id) REFERENCES society (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F09B2CA443B21DF3 ON parameters_society (id_society_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parameters_society DROP FOREIGN KEY FK_F09B2CA443B21DF3');
        $this->addSql('DROP INDEX UNIQ_F09B2CA443B21DF3 ON parameters_society');
        $this->addSql('ALTER TABLE parameters_society DROP id_society_id');
    }
}

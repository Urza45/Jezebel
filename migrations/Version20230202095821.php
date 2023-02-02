<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230202095821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD society_id INT DEFAULT NULL, ADD id_admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9E6389D24 FOREIGN KEY (society_id) REFERENCES society (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E934F06E85 FOREIGN KEY (id_admin_id) REFERENCES admin (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E6389D24 ON users (society_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E934F06E85 ON users (id_admin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9E6389D24');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E934F06E85');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E6389D24 ON users');
        $this->addSql('DROP INDEX UNIQ_1483A5E934F06E85 ON users');
        $this->addSql('ALTER TABLE users DROP society_id, DROP id_admin_id');
    }
}

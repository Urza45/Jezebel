<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126184320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin CHANGE society_id society_id INT NOT NULL');
        $this->addSql('ALTER TABLE client CHANGE codeagence codeagence VARCHAR(255) DEFAULT \'78\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin CHANGE society_id society_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client CHANGE codeagence codeagence INT DEFAULT 78 NOT NULL');
    }
}

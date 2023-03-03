<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226103438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, norme_id INT DEFAULT NULL, intitule VARCHAR(255) NOT NULL, INDEX IDX_A412FA926F0D55C9 (norme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA926F0D55C9 FOREIGN KEY (norme_id) REFERENCES norme (id)');
        $this->addSql('ALTER TABLE theme_theorique ADD quiz_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE theme_theorique ADD CONSTRAINT FK_5938281C853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE INDEX IDX_5938281C853CD175 ON theme_theorique (quiz_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE theme_theorique DROP FOREIGN KEY FK_5938281C853CD175');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA926F0D55C9');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP INDEX IDX_5938281C853CD175 ON theme_theorique');
        $this->addSql('ALTER TABLE theme_theorique DROP quiz_id');
    }
}

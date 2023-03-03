<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221164934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions ADD sous_theme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5514C40D2 FOREIGN KEY (sous_theme_id) REFERENCES sous_theme (id)');
        $this->addSql('CREATE INDEX IDX_8ADC54D5514C40D2 ON questions (sous_theme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5514C40D2');
        $this->addSql('DROP INDEX IDX_8ADC54D5514C40D2 ON questions');
        $this->addSql('ALTER TABLE questions DROP sous_theme_id');
    }
}

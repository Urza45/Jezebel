<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302110953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_quiz_result ADD quiz_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_quiz_result ADD CONSTRAINT FK_5735F8DF853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE INDEX IDX_5735F8DF853CD175 ON user_quiz_result (quiz_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_quiz_result DROP FOREIGN KEY FK_5735F8DF853CD175');
        $this->addSql('DROP INDEX IDX_5735F8DF853CD175 ON user_quiz_result');
        $this->addSql('ALTER TABLE user_quiz_result DROP quiz_id');
    }
}

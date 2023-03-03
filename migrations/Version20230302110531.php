<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302110531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_quiz_answer DROP FOREIGN KEY FK_9E8273E9F9378536');
        $this->addSql('DROP INDEX IDX_9E8273E9F9378536 ON user_quiz_answer');
        $this->addSql('ALTER TABLE user_quiz_answer CHANGE quesstion_id question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_quiz_answer ADD CONSTRAINT FK_9E8273E91E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('CREATE INDEX IDX_9E8273E91E27F6BF ON user_quiz_answer (question_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_quiz_answer DROP FOREIGN KEY FK_9E8273E91E27F6BF');
        $this->addSql('DROP INDEX IDX_9E8273E91E27F6BF ON user_quiz_answer');
        $this->addSql('ALTER TABLE user_quiz_answer CHANGE question_id quesstion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_quiz_answer ADD CONSTRAINT FK_9E8273E9F9378536 FOREIGN KEY (quesstion_id) REFERENCES questions (id)');
        $this->addSql('CREATE INDEX IDX_9E8273E9F9378536 ON user_quiz_answer (quesstion_id)');
    }
}

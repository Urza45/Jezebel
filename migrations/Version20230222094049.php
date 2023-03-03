<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222094049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_quiz_answer (id INT AUTO_INCREMENT NOT NULL, quesstion_id INT DEFAULT NULL, answer_id INT DEFAULT NULL, user_quiz_result_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, INDEX IDX_9E8273E9F9378536 (quesstion_id), INDEX IDX_9E8273E9AA334807 (answer_id), INDEX IDX_9E8273E96A4218FC (user_quiz_result_id), INDEX IDX_9E8273E98D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_quiz_answer ADD CONSTRAINT FK_9E8273E9F9378536 FOREIGN KEY (quesstion_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE user_quiz_answer ADD CONSTRAINT FK_9E8273E9AA334807 FOREIGN KEY (answer_id) REFERENCES answers (id)');
        $this->addSql('ALTER TABLE user_quiz_answer ADD CONSTRAINT FK_9E8273E96A4218FC FOREIGN KEY (user_quiz_result_id) REFERENCES user_quiz_result (id)');
        $this->addSql('ALTER TABLE user_quiz_answer ADD CONSTRAINT FK_9E8273E98D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_quiz_answer DROP FOREIGN KEY FK_9E8273E9F9378536');
        $this->addSql('ALTER TABLE user_quiz_answer DROP FOREIGN KEY FK_9E8273E9AA334807');
        $this->addSql('ALTER TABLE user_quiz_answer DROP FOREIGN KEY FK_9E8273E96A4218FC');
        $this->addSql('ALTER TABLE user_quiz_answer DROP FOREIGN KEY FK_9E8273E98D0EB82');
        $this->addSql('DROP TABLE user_quiz_answer');
    }
}

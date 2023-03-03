<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222093405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_quiz_result (id INT AUTO_INCREMENT NOT NULL, candidat_id INT DEFAULT NULL, norme_id INT DEFAULT NULL, INDEX IDX_5735F8DF8D0EB82 (candidat_id), INDEX IDX_5735F8DF6F0D55C9 (norme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_quiz_result ADD CONSTRAINT FK_5735F8DF8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE user_quiz_result ADD CONSTRAINT FK_5735F8DF6F0D55C9 FOREIGN KEY (norme_id) REFERENCES norme (id)');
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C6061E27F6BF');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6061E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5514C40D2');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5514C40D2 FOREIGN KEY (sous_theme_id) REFERENCES sous_theme (id)');
        $this->addSql('ALTER TABLE sous_theme DROP FOREIGN KEY FK_E891E7ED6228949');
        $this->addSql('ALTER TABLE sous_theme ADD CONSTRAINT FK_E891E7ED6228949 FOREIGN KEY (theme_theorique_id) REFERENCES theme_theorique (id)');
        $this->addSql('ALTER TABLE theme_theorique DROP FOREIGN KEY FK_5938281C4142BD3C');
        $this->addSql('ALTER TABLE theme_theorique ADD CONSTRAINT FK_5938281C4142BD3C FOREIGN KEY (norme_id_id) REFERENCES norme (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_quiz_result DROP FOREIGN KEY FK_5735F8DF8D0EB82');
        $this->addSql('ALTER TABLE user_quiz_result DROP FOREIGN KEY FK_5735F8DF6F0D55C9');
        $this->addSql('DROP TABLE user_quiz_result');
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C6061E27F6BF');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6061E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5514C40D2');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5514C40D2 FOREIGN KEY (sous_theme_id) REFERENCES sous_theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sous_theme DROP FOREIGN KEY FK_E891E7ED6228949');
        $this->addSql('ALTER TABLE sous_theme ADD CONSTRAINT FK_E891E7ED6228949 FOREIGN KEY (theme_theorique_id) REFERENCES theme_theorique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_theorique DROP FOREIGN KEY FK_5938281C4142BD3C');
        $this->addSql('ALTER TABLE theme_theorique ADD CONSTRAINT FK_5938281C4142BD3C FOREIGN KEY (norme_id_id) REFERENCES norme (id) ON DELETE CASCADE');
    }
}

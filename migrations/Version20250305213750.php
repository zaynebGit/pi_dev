<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250305213750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, matiere VARCHAR(255) NOT NULL, quest1 VARCHAR(255) NOT NULL, quest2 VARCHAR(255) NOT NULL, quest3 VARCHAR(255) NOT NULL, correct_answer1 VARCHAR(255) NOT NULL, correct_answer2 VARCHAR(255) NOT NULL, correct_answer3 VARCHAR(255) NOT NULL, diff VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resp_quiz (id INT AUTO_INCREMENT NOT NULL, quiz_id INT NOT NULL, user_answer1 VARCHAR(255) NOT NULL, user_answer2 VARCHAR(255) NOT NULL, user_answer3 VARCHAR(255) NOT NULL, submitted_at DATETIME DEFAULT NULL, rate INT DEFAULT NULL, score INT DEFAULT NULL, INDEX IDX_49E0EBC1853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resp_quiz ADD CONSTRAINT FK_49E0EBC1853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resp_quiz DROP FOREIGN KEY FK_49E0EBC1853CD175');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE resp_quiz');
    }
}

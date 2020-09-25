<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906130454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course ADD course_style_id INT NOT NULL, ADD reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB913790D22 FOREIGN KEY (course_style_id) REFERENCES course_style (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB913790D22 ON course (course_style_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9B83297E7 ON course (reservation_id)');
        $this->addSql('ALTER TABLE reservation ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_42C84955A76ED395 ON reservation (user_id)');
        $this->addSql('ALTER TABLE user_ticket_book ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_ticket_book ADD CONSTRAINT FK_50257F9CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_50257F9CA76ED395 ON user_ticket_book (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB913790D22');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9B83297E7');
        $this->addSql('DROP INDEX IDX_169E6FB913790D22 ON course');
        $this->addSql('DROP INDEX IDX_169E6FB9B83297E7 ON course');
        $this->addSql('ALTER TABLE course DROP course_style_id, DROP reservation_id');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('DROP INDEX IDX_42C84955A76ED395 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP user_id');
        $this->addSql('ALTER TABLE user_ticket_book DROP FOREIGN KEY FK_50257F9CA76ED395');
        $this->addSql('DROP INDEX IDX_50257F9CA76ED395 ON user_ticket_book');
        $this->addSql('ALTER TABLE user_ticket_book DROP user_id');
    }
}

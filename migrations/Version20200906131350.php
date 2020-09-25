<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906131350 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_book ADD user_ticket_book_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket_book ADD CONSTRAINT FK_F93EB60971EB358A FOREIGN KEY (user_ticket_book_id) REFERENCES user_ticket_book (id)');
        $this->addSql('CREATE INDEX IDX_F93EB60971EB358A ON ticket_book (user_ticket_book_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_book DROP FOREIGN KEY FK_F93EB60971EB358A');
        $this->addSql('DROP INDEX IDX_F93EB60971EB358A ON ticket_book');
        $this->addSql('ALTER TABLE ticket_book DROP user_ticket_book_id');
    }
}

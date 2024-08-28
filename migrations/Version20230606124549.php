<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606124549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE line_attachment (id INT AUTO_INCREMENT NOT NULL, line_army_id INT DEFAULT NULL, attachment_id INT DEFAULT NULL, INDEX IDX_C7E4CA50AD76F54A (line_army_id), INDEX IDX_C7E4CA50464E68B (attachment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE line_attachment ADD CONSTRAINT FK_C7E4CA50AD76F54A FOREIGN KEY (line_army_id) REFERENCES line_army (id)');
        $this->addSql('ALTER TABLE line_attachment ADD CONSTRAINT FK_C7E4CA50464E68B FOREIGN KEY (attachment_id) REFERENCES attachment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_attachment DROP FOREIGN KEY FK_C7E4CA50AD76F54A');
        $this->addSql('ALTER TABLE line_attachment DROP FOREIGN KEY FK_C7E4CA50464E68B');
        $this->addSql('DROP TABLE line_attachment');
    }
}

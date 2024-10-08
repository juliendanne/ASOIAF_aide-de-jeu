<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613152339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_attachment ADD army_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_attachment ADD CONSTRAINT FK_C7E4CA5018D2742D FOREIGN KEY (army_id) REFERENCES army (id)');
        $this->addSql('CREATE INDEX IDX_C7E4CA5018D2742D ON line_attachment (army_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_attachment DROP FOREIGN KEY FK_C7E4CA5018D2742D');
        $this->addSql('DROP INDEX IDX_C7E4CA5018D2742D ON line_attachment');
        $this->addSql('ALTER TABLE line_attachment DROP army_id');
    }
}

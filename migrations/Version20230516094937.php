<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516094937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE combat_unit_army (combat_unit_id INT NOT NULL, army_id INT NOT NULL, INDEX IDX_6CF16228CC7C2DCF (combat_unit_id), INDEX IDX_6CF1622818D2742D (army_id), PRIMARY KEY(combat_unit_id, army_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE combat_unit_army ADD CONSTRAINT FK_6CF16228CC7C2DCF FOREIGN KEY (combat_unit_id) REFERENCES combat_unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE combat_unit_army ADD CONSTRAINT FK_6CF1622818D2742D FOREIGN KEY (army_id) REFERENCES army (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE combat_unit_army DROP FOREIGN KEY FK_6CF16228CC7C2DCF');
        $this->addSql('ALTER TABLE combat_unit_army DROP FOREIGN KEY FK_6CF1622818D2742D');
        $this->addSql('DROP TABLE combat_unit_army');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615151835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE army_no_combat_unit (army_id INT NOT NULL, no_combat_unit_id INT NOT NULL, INDEX IDX_1F51BF2918D2742D (army_id), INDEX IDX_1F51BF298B53C73F (no_combat_unit_id), PRIMARY KEY(army_id, no_combat_unit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE army_no_combat_unit ADD CONSTRAINT FK_1F51BF2918D2742D FOREIGN KEY (army_id) REFERENCES army (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE army_no_combat_unit ADD CONSTRAINT FK_1F51BF298B53C73F FOREIGN KEY (no_combat_unit_id) REFERENCES no_combat_unit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE army_no_combat_unit DROP FOREIGN KEY FK_1F51BF2918D2742D');
        $this->addSql('ALTER TABLE army_no_combat_unit DROP FOREIGN KEY FK_1F51BF298B53C73F');
        $this->addSql('DROP TABLE army_no_combat_unit');
    }
}

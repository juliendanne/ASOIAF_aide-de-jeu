<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331150348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachment ADD combat_unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BBCC7C2DCF FOREIGN KEY (combat_unit_id) REFERENCES combat_unit (id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBCC7C2DCF ON attachment (combat_unit_id)');
        $this->addSql('ALTER TABLE combat_unit ADD faction_id INT NOT NULL, ADD type_of_unit_id INT NOT NULL, ADD cost INT NOT NULL, ADD solo_unit TINYINT(1) NOT NULL, ADD card VARCHAR(255) DEFAULT NULL, ADD card_verso VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE combat_unit ADD CONSTRAINT FK_47715CCE4448F8DA FOREIGN KEY (faction_id) REFERENCES faction (id)');
        $this->addSql('ALTER TABLE combat_unit ADD CONSTRAINT FK_47715CCE18CB5799 FOREIGN KEY (type_of_unit_id) REFERENCES type_of_unit (id)');
        $this->addSql('CREATE INDEX IDX_47715CCE4448F8DA ON combat_unit (faction_id)');
        $this->addSql('CREATE INDEX IDX_47715CCE18CB5799 ON combat_unit (type_of_unit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachment DROP FOREIGN KEY FK_795FD9BBCC7C2DCF');
        $this->addSql('DROP INDEX IDX_795FD9BBCC7C2DCF ON attachment');
        $this->addSql('ALTER TABLE attachment DROP combat_unit_id');
        $this->addSql('ALTER TABLE combat_unit DROP FOREIGN KEY FK_47715CCE4448F8DA');
        $this->addSql('ALTER TABLE combat_unit DROP FOREIGN KEY FK_47715CCE18CB5799');
        $this->addSql('DROP INDEX IDX_47715CCE4448F8DA ON combat_unit');
        $this->addSql('DROP INDEX IDX_47715CCE18CB5799 ON combat_unit');
        $this->addSql('ALTER TABLE combat_unit DROP faction_id, DROP type_of_unit_id, DROP cost, DROP solo_unit, DROP card, DROP card_verso');
    }
}

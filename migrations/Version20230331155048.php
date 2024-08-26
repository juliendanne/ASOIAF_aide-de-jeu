<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331155048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE army (id INT AUTO_INCREMENT NOT NULL, commander_id INT DEFAULT NULL, faction_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, limit_cost INT NOT NULL, total_cost INT DEFAULT NULL, INDEX IDX_C212F363349A583 (commander_id), INDEX IDX_C212F364448F8DA (faction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE army ADD CONSTRAINT FK_C212F363349A583 FOREIGN KEY (commander_id) REFERENCES commander (id)');
        $this->addSql('ALTER TABLE army ADD CONSTRAINT FK_C212F364448F8DA FOREIGN KEY (faction_id) REFERENCES faction (id)');
        $this->addSql('ALTER TABLE attachment ADD faction_id INT NOT NULL, ADD type_id INT NOT NULL, ADD is_a_character TINYINT(1) NOT NULL, ADD full_name VARCHAR(255) DEFAULT NULL, ADD cost INT NOT NULL, ADD card VARCHAR(255) DEFAULT NULL, ADD card_verso VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BB4448F8DA FOREIGN KEY (faction_id) REFERENCES faction (id)');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BBC54C8C93 FOREIGN KEY (type_id) REFERENCES type_of_unit (id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB4448F8DA ON attachment (faction_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBC54C8C93 ON attachment (type_id)');
        $this->addSql('ALTER TABLE combat_unit ADD army_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE combat_unit ADD CONSTRAINT FK_47715CCE18D2742D FOREIGN KEY (army_id) REFERENCES army (id)');
        $this->addSql('CREATE INDEX IDX_47715CCE18D2742D ON combat_unit (army_id)');
        $this->addSql('ALTER TABLE commander ADD faction_id INT NOT NULL, ADD type_id INT NOT NULL, ADD attached_to_unit_id INT DEFAULT NULL, ADD full_name VARCHAR(255) NOT NULL, ADD is_a_character TINYINT(1) NOT NULL, ADD solo_unit TINYINT(1) NOT NULL, ADD cost INT NOT NULL, ADD card VARCHAR(255) DEFAULT NULL, ADD card_verso VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE commander ADD CONSTRAINT FK_42D318BA4448F8DA FOREIGN KEY (faction_id) REFERENCES faction (id)');
        $this->addSql('ALTER TABLE commander ADD CONSTRAINT FK_42D318BAC54C8C93 FOREIGN KEY (type_id) REFERENCES type_of_unit (id)');
        $this->addSql('ALTER TABLE commander ADD CONSTRAINT FK_42D318BA8E95E93C FOREIGN KEY (attached_to_unit_id) REFERENCES combat_unit (id)');
        $this->addSql('CREATE INDEX IDX_42D318BA4448F8DA ON commander (faction_id)');
        $this->addSql('CREATE INDEX IDX_42D318BAC54C8C93 ON commander (type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42D318BA8E95E93C ON commander (attached_to_unit_id)');
        $this->addSql('ALTER TABLE no_combat_unit ADD faction_id INT NOT NULL, ADD army_id INT DEFAULT NULL, ADD full_name VARCHAR(255) NOT NULL, ADD is_a_character TINYINT(1) NOT NULL, ADD cost INT NOT NULL, ADD card VARCHAR(255) DEFAULT NULL, ADD card_verso VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE no_combat_unit ADD CONSTRAINT FK_DD67845A4448F8DA FOREIGN KEY (faction_id) REFERENCES faction (id)');
        $this->addSql('ALTER TABLE no_combat_unit ADD CONSTRAINT FK_DD67845A18D2742D FOREIGN KEY (army_id) REFERENCES army (id)');
        $this->addSql('CREATE INDEX IDX_DD67845A4448F8DA ON no_combat_unit (faction_id)');
        $this->addSql('CREATE INDEX IDX_DD67845A18D2742D ON no_combat_unit (army_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE combat_unit DROP FOREIGN KEY FK_47715CCE18D2742D');
        $this->addSql('ALTER TABLE no_combat_unit DROP FOREIGN KEY FK_DD67845A18D2742D');
        $this->addSql('ALTER TABLE army DROP FOREIGN KEY FK_C212F363349A583');
        $this->addSql('ALTER TABLE army DROP FOREIGN KEY FK_C212F364448F8DA');
        $this->addSql('DROP TABLE army');
        $this->addSql('ALTER TABLE attachment DROP FOREIGN KEY FK_795FD9BB4448F8DA');
        $this->addSql('ALTER TABLE attachment DROP FOREIGN KEY FK_795FD9BBC54C8C93');
        $this->addSql('DROP INDEX IDX_795FD9BB4448F8DA ON attachment');
        $this->addSql('DROP INDEX IDX_795FD9BBC54C8C93 ON attachment');
        $this->addSql('ALTER TABLE attachment DROP faction_id, DROP type_id, DROP is_a_character, DROP full_name, DROP cost, DROP card, DROP card_verso');
        $this->addSql('DROP INDEX IDX_47715CCE18D2742D ON combat_unit');
        $this->addSql('ALTER TABLE combat_unit DROP army_id');
        $this->addSql('ALTER TABLE commander DROP FOREIGN KEY FK_42D318BA4448F8DA');
        $this->addSql('ALTER TABLE commander DROP FOREIGN KEY FK_42D318BAC54C8C93');
        $this->addSql('ALTER TABLE commander DROP FOREIGN KEY FK_42D318BA8E95E93C');
        $this->addSql('DROP INDEX IDX_42D318BA4448F8DA ON commander');
        $this->addSql('DROP INDEX IDX_42D318BAC54C8C93 ON commander');
        $this->addSql('DROP INDEX UNIQ_42D318BA8E95E93C ON commander');
        $this->addSql('ALTER TABLE commander DROP faction_id, DROP type_id, DROP attached_to_unit_id, DROP full_name, DROP is_a_character, DROP solo_unit, DROP cost, DROP card, DROP card_verso');
        $this->addSql('ALTER TABLE no_combat_unit DROP FOREIGN KEY FK_DD67845A4448F8DA');
        $this->addSql('DROP INDEX IDX_DD67845A4448F8DA ON no_combat_unit');
        $this->addSql('DROP INDEX IDX_DD67845A18D2742D ON no_combat_unit');
        $this->addSql('ALTER TABLE no_combat_unit DROP faction_id, DROP army_id, DROP full_name, DROP is_a_character, DROP cost, DROP card, DROP card_verso');
    }
}

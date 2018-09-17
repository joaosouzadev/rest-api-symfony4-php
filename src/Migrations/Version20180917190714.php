<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180917190714 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE papel (id INT AUTO_INCREMENT NOT NULL, pessoa_id INT DEFAULT NULL, filme_id INT DEFAULT NULL, personagem VARCHAR(255) NOT NULL, INDEX IDX_B4155D75DF6FA0A5 (pessoa_id), INDEX IDX_B4155D75E6E418AD (filme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE papel ADD CONSTRAINT FK_B4155D75DF6FA0A5 FOREIGN KEY (pessoa_id) REFERENCES pessoa (id)');
        $this->addSql('ALTER TABLE papel ADD CONSTRAINT FK_B4155D75E6E418AD FOREIGN KEY (filme_id) REFERENCES filme (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE papel');
    }
}

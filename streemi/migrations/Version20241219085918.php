<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219085918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist_subcription CHANGE subscriber_id subscriber_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE watch_history DROP FOREIGN KEY FK_DE44EFD899E6F5DF');
        $this->addSql('DROP INDEX IDX_DE44EFD899E6F5DF ON watch_history');
        $this->addSql('ALTER TABLE watch_history ADD watcher_id INT DEFAULT NULL, DROP player_id');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD8C300AB5D FOREIGN KEY (watcher_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_DE44EFD8C300AB5D ON watch_history (watcher_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE watch_history DROP FOREIGN KEY FK_DE44EFD8C300AB5D');
        $this->addSql('DROP INDEX IDX_DE44EFD8C300AB5D ON watch_history');
        $this->addSql('ALTER TABLE watch_history ADD player_id INT NOT NULL, DROP watcher_id');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD899E6F5DF FOREIGN KEY (player_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DE44EFD899E6F5DF ON watch_history (player_id)');
        $this->addSql('ALTER TABLE playlist_subcription CHANGE subscriber_id subscriber_id INT NOT NULL');
    }
}

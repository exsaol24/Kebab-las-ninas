<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250319194907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detallespedidos ADD pedido_id INT NOT NULL, ADD platos_id INT NOT NULL');
        $this->addSql('ALTER TABLE detallespedidos ADD CONSTRAINT FK_8111551B4854653A FOREIGN KEY (pedido_id) REFERENCES pedidos (id)');
        $this->addSql('ALTER TABLE detallespedidos ADD CONSTRAINT FK_8111551BD77499C5 FOREIGN KEY (platos_id) REFERENCES platos (id)');
        $this->addSql('CREATE INDEX IDX_8111551B4854653A ON detallespedidos (pedido_id)');
        $this->addSql('CREATE INDEX IDX_8111551BD77499C5 ON detallespedidos (platos_id)');
        $this->addSql('ALTER TABLE direcciones ADD usuarios_id INT NOT NULL');
        $this->addSql('ALTER TABLE direcciones ADD CONSTRAINT FK_B0B0BECBF01D3B25 FOREIGN KEY (usuarios_id) REFERENCES usuarios (id)');
        $this->addSql('CREATE INDEX IDX_B0B0BECBF01D3B25 ON direcciones (usuarios_id)');
        $this->addSql('ALTER TABLE historialventas ADD pedido_id INT NOT NULL');
        $this->addSql('ALTER TABLE historialventas ADD CONSTRAINT FK_78D8FA064854653A FOREIGN KEY (pedido_id) REFERENCES pedidos (id)');
        $this->addSql('CREATE INDEX IDX_78D8FA064854653A ON historialventas (pedido_id)');
        $this->addSql('ALTER TABLE pedidos ADD usuarios_id INT NOT NULL, ADD estado_id INT NOT NULL');
        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAAF01D3B25 FOREIGN KEY (usuarios_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAA9F5A440B FOREIGN KEY (estado_id) REFERENCES estadospedidos (id)');
        $this->addSql('CREATE INDEX IDX_6716CCAAF01D3B25 ON pedidos (usuarios_id)');
        $this->addSql('CREATE INDEX IDX_6716CCAA9F5A440B ON pedidos (estado_id)');
        $this->addSql('ALTER TABLE platos ADD categoria_id INT NOT NULL');
        $this->addSql('ALTER TABLE platos ADD CONSTRAINT FK_1D29312A3397707A FOREIGN KEY (categoria_id) REFERENCES categorias (id)');
        $this->addSql('CREATE INDEX IDX_1D29312A3397707A ON platos (categoria_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE platos DROP FOREIGN KEY FK_1D29312A3397707A');
        $this->addSql('DROP INDEX IDX_1D29312A3397707A ON platos');
        $this->addSql('ALTER TABLE platos DROP categoria_id');
        $this->addSql('ALTER TABLE detallespedidos DROP FOREIGN KEY FK_8111551B4854653A');
        $this->addSql('ALTER TABLE detallespedidos DROP FOREIGN KEY FK_8111551BD77499C5');
        $this->addSql('DROP INDEX IDX_8111551B4854653A ON detallespedidos');
        $this->addSql('DROP INDEX IDX_8111551BD77499C5 ON detallespedidos');
        $this->addSql('ALTER TABLE detallespedidos DROP pedido_id, DROP platos_id');
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAAF01D3B25');
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAA9F5A440B');
        $this->addSql('DROP INDEX IDX_6716CCAAF01D3B25 ON pedidos');
        $this->addSql('DROP INDEX IDX_6716CCAA9F5A440B ON pedidos');
        $this->addSql('ALTER TABLE pedidos DROP usuarios_id, DROP estado_id');
        $this->addSql('ALTER TABLE direcciones DROP FOREIGN KEY FK_B0B0BECBF01D3B25');
        $this->addSql('DROP INDEX IDX_B0B0BECBF01D3B25 ON direcciones');
        $this->addSql('ALTER TABLE direcciones DROP usuarios_id');
        $this->addSql('ALTER TABLE historialventas DROP FOREIGN KEY FK_78D8FA064854653A');
        $this->addSql('DROP INDEX IDX_78D8FA064854653A ON historialventas');
        $this->addSql('ALTER TABLE historialventas DROP pedido_id');
    }
}

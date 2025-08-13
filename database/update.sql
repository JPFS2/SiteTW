-- Adiciona coluna tipo_usuario na tabela cadusuario
ALTER TABLE cadusuario ADD COLUMN tipo_usuario VARCHAR(20) DEFAULT 'user';
 
-- Atualiza usuários existentes para admin
UPDATE cadusuario SET tipo_usuario = 'admin' WHERE codusur = 1; 
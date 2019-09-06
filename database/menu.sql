CREATE TABLE examen.menu (
	id INTEGER NULL AUTO_INCREMENT,
	name VARCHAR(15) NULL,
	description VARCHAR(140) NULL,
	CONSTRAINT menu_PK PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

CREATE TABLE examen.manu_relationship (
	id INTEGER NOT NULL AUTO_INCREMENT,
	id_parent INTEGER NULL,
	id_child INTEGER NULL,
	CONSTRAINT manu_relationship_PK PRIMARY KEY (id),
	CONSTRAINT manu_relationship_FK_1 FOREIGN KEY (id_child) REFERENCES examen.menu(id),
	CONSTRAINT manu_relationship_FK FOREIGN KEY (id_parent) REFERENCES examen.menu(id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

ALTER TABLE examen.manu_relationship MODIFY COLUMN id VARCHAR(40) NOT NULL;
ALTER TABLE examen.manu_relationship DROP FOREIGN KEY manu_relationship_FK_1;
ALTER TABLE examen.manu_relationship DROP FOREIGN KEY manu_relationship_FK;
ALTER TABLE examen.menu MODIFY COLUMN id VARCHAR(40) NOT NULL;
ALTER TABLE examen.manu_relationship MODIFY COLUMN id_parent VARCHAR(40) NOT NULL;
ALTER TABLE examen.manu_relationship MODIFY COLUMN id_child VARCHAR(40) NOT NULL;
ALTER TABLE examen.manu_relationship ADD CONSTRAINT manu_relationship_FK FOREIGN KEY (id_parent) REFERENCES examen.menu(id);
ALTER TABLE examen.manu_relationship ADD CONSTRAINT manu_relationship_FK_1 FOREIGN KEY (id_child) REFERENCES examen.menu(id);

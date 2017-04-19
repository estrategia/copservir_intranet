

DELETE FROM auth_assignment where item_name = "formacionComunicaciones_admin";
DELETE FROM auth_item_child where child like "formacionComunicaciones_%";
DELETE FROM auth_item where name like "formacionComunicaciones_%";


INSERT INTO auth_item (name,type,title,url,description,rule_name,data,visualizacionMenus,moduloDestino,moduloPadre,created_at,updated_at) VALUES ('formacionComunicaciones_admin',1,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL);
INSERT INTO auth_item (name,type,title,url,description,rule_name,data,visualizacionMenus,moduloDestino,moduloPadre,created_at,updated_at) VALUES ('formacionComunicaciones_capitulo_admin',2,'Capitulos de Contenido','/intranet/formacioncomunicaciones/capitulo','Permite administrar los capitulos del modulo de formacion y comunicaciones',NULL,NULL,0,'intranet','formacioncomunicaciones',NULL,NULL);
INSERT INTO auth_item (name,type,title,url,description,rule_name,data,visualizacionMenus,moduloDestino,moduloPadre,created_at,updated_at) VALUES ('formacionComunicaciones_contenido_admin',2,'Administrar Contenidos','/intranet/formacioncomunicaciones/contenido','Permite administrar los contenidos del modulo de formacion y comunicaciones',NULL,NULL,0,'intranet','formacioncomunicaciones',NULL,NULL);
INSERT INTO auth_item (name,type,title,url,description,rule_name,data,visualizacionMenus,moduloDestino,moduloPadre,created_at,updated_at) VALUES ('formacionComunicaciones_cuestionario_admin',2,'Administrar cuestionarios','/intranet/formacioncomunicaciones/cuestionario','Parametrizaciòn de cuestionarios',NULL,NULL,1,'intranet','formacioncomunicaciones',NULL,NULL);
INSERT INTO auth_item (name,type,title,url,description,rule_name,data,visualizacionMenus,moduloDestino,moduloPadre,created_at,updated_at) VALUES ('formacionComunicaciones_cuestionario_cuestionario-usuarios',2,'Reporte cuestionario usuarios','/intranet/formacioncomunicaciones/cuestionario/cuestionario-usuarios','Reporte de usuarios respecto a los cuestionarios que han resuelto',NULL,NULL,1,'intranet','formacioncomunicaciones',NULL,NULL);
INSERT INTO auth_item (name,type,title,url,description,rule_name,data,visualizacionMenus,moduloDestino,moduloPadre,created_at,updated_at) VALUES ('formacionComunicaciones_curso_admin',2,'Administrar cursos','/intranet/formacioncomunicaciones/curso','Permite administrar cursos del modulo formacion y comunicaciones',NULL,NULL,1,'intranet','formacioncomunicaciones',NULL,NULL);
INSERT INTO auth_item (name,type,title,url,description,rule_name,data,visualizacionMenus,moduloDestino,moduloPadre,created_at,updated_at) VALUES ('formacionComunicaciones_modulo_admin',2,'Modulos de Contenido','/intranet/formacioncomunicaciones/modulo','Permite administrar los modulos de los cursos del modulo de formacion y comunicaciones',NULL,NULL,0,'intranet','formacioncomunicaciones',NULL,NULL);
INSERT INTO auth_item (name,type,title,url,description,rule_name,data,visualizacionMenus,moduloDestino,moduloPadre,created_at,updated_at) VALUES ('formacionComunicaciones_tipoContenido_admin',2,'Tipos de Contenido','/intranet/formacioncomunicaciones/tipo-contenido','Permite administrar los tipos de contenido del modulo de formacion y comunicaciones',NULL,NULL,1,'intranet','formacioncomunicaciones',NULL,NULL);


INSERT INTO auth_item_child (parent,child) VALUES ('formacionComunicaciones_admin','formacionComunicaciones_capitulo_admin');
INSERT INTO auth_item_child (parent,child) VALUES ('formacionComunicaciones_admin','formacionComunicaciones_contenido_admin');
INSERT INTO auth_item_child (parent,child) VALUES ('formacionComunicaciones_admin','formacionComunicaciones_cuestionario_admin');
INSERT INTO auth_item_child (parent,child) VALUES ('formacionComunicaciones_admin','formacionComunicaciones_cuestionario_cuestionario-usuarios');
INSERT INTO auth_item_child (parent,child) VALUES ('formacionComunicaciones_admin','formacionComunicaciones_curso_admin');
INSERT INTO auth_item_child (parent,child) VALUES ('formacionComunicaciones_admin','formacionComunicaciones_modulo_admin');
INSERT INTO auth_item_child (parent,child) VALUES ('formacionComunicaciones_admin','formacionComunicaciones_tipoContenido_admin');
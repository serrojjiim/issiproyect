CL SCR;
drop table cargo;
drop table jefeMaquina;
drop table cogeCamion;
drop table camion;
drop table lineaPedidoProveedor;
drop table material;
drop table pedidoProveedor;
drop table proveedor;
drop table lineaPedidoCliente;
drop table producto;
drop table pedidoCliente;
drop table cliente;
drop table nomina;
drop table peticiondias;
drop table empleado;
drop table maquina;

CREATE TABLE cargo (
    oid_cargo   INTEGER NOT NULL,
    rol         VARCHAR(20),
    PRIMARY KEY ( oid_cargo )
);
/

INSERT INTO cargo VALUES (1, 'presidente');
INSERT INTO cargo VALUES (2, 'vicepresidente');
INSERT INTO cargo VALUES (3, 'secretario');
INSERT INTO cargo VALUES (4, 'tesorero');
INSERT INTO cargo VALUES (5, 'gerenteVentas');
INSERT INTO cargo VALUES (6, 'gerenteCompras');
INSERT INTO cargo VALUES (7, 'capataz');
INSERT INTO cargo VALUES (8, 'jefePersonal');
INSERT INTO cargo VALUES (9, 'jefeMaquina');
INSERT INTO cargo VALUES (10, 'peon');
INSERT INTO cargo VALUES (11, 'camionero');
    

CREATE TABLE maquina (
    oid_maq   INTEGER NOT NULL,
    nombre    VARCHAR(50),
    PRIMARY KEY ( oid_maq )
);

CREATE TABLE empleado (
    oid_emp             INTEGER NOT NULL,
    dni                 CHAR(9) UNIQUE NOT NULL,
    nombre              VARCHAR(30) NOT NULL,
    apellidos           VARCHAR(30) NOT NULL,
    telefono            CHAR(9),
    direccion           VARCHAR(50),
    cargo               NUMBER(2),
    capitalsocial       INTEGER,
    fechacontratacion   DATE,
    diasvacaciones      INTEGER,
    oid_maq             INTEGER,
    pass              VARCHAR(70),
    oculto             INTEGER DEFAULT 0,
    PRIMARY KEY ( oid_emp ),
    FOREIGN KEY ( oid_maq ) REFERENCES maquina
);

CREATE TABLE peticiondias (
    oid_peticiondias   INTEGER NOT NULL,
    oid_emp   INTEGER,
    dias   INTEGER,
    motivo VARCHAR(400),
    aceptada NUMBER(1) DEFAULT 3,
    PRIMARY KEY (oid_peticiondias),
    FOREIGN KEY ( oid_emp ) REFERENCES empleado
);


CREATE TABLE jefeMaquina (
    oid_jefemaq   INTEGER NOT NULL,
    oid_emp   INTEGER UNIQUE,
    oid_maq   INTEGER UNIQUE,
    PRIMARY KEY ( oid_jefemaq ),
    FOREIGN KEY ( oid_emp ) REFERENCES empleado,
    FOREIGN KEY ( oid_maq ) REFERENCES maquina
);

CREATE UNIQUE INDEX indiceJefeMaquina
ON jefeMaquina ( oid_emp ASC, oid_maq ASC );

CREATE TABLE nomina (
    oid_nom   INTEGER NOT NULL,
    mes       INTEGER,
    año       INTEGER,
    salario   INTEGER,
    oid_emp   INTEGER,
    PRIMARY KEY ( oid_nom ),
    FOREIGN KEY ( oid_emp ) REFERENCES empleado
);

CREATE TABLE cliente (
    oid_cli     INTEGER NOT NULL,
    cif         CHAR(9) UNIQUE NOT NULL,
    nombre      VARCHAR(30) UNIQUE NOT NULL,
    direccion   VARCHAR(50),
    telefono    NUMBER(9),
    email       VARCHAR(50),
    oculto      INTEGER DEFAULT 0,
    PRIMARY KEY ( oid_cli )
);

CREATE TABLE pedidocliente (
    oid_pedcli            INTEGER NOT NULL,
    fechapedido           TIMESTAMP (0) WITH TIME ZONE NOT NULL,
    fechafinfabricacion   TIMESTAMP (0)   WITH TIME ZONE,   -- Función actualizar en paquete
    fechaenvio            TIMESTAMP (0)   WITH TIME ZONE,                  -- Función actualizar en paquete
    fechallegada          TIMESTAMP (0)   WITH TIME ZONE,                 -- Función actualizar en paquete
    fechapago             TIMESTAMP (0)   WITH TIME ZONE,                -- Función actualizar en paquete
    costetotal            INTEGER DEFAULT 0,                                          -- Se tiene que actualizar mediante un trigger
    oid_cli               INTEGER NOT NULL, 
    oid_emp               INTEGER NOT NULL,
    PRIMARY KEY ( oid_pedcli ),
    FOREIGN KEY ( oid_cli ) REFERENCES cliente,
    FOREIGN KEY ( oid_emp ) REFERENCES empleado

);

CREATE TABLE producto (
    oid_prod        INTEGER NOT NULL,
    nombre          VARCHAR(30) UNIQUE,
    precio          NUMBER(*, 2),
    longitud        INTEGER,
    profundidad     INTEGER,
    altura          INTEGER,
    acabado         VARCHAR(40),
    urlfoto         VARCHAR(500),
    PRIMARY KEY ( oid_prod )
);

CREATE TABLE lineapedidocliente (
    oid_linpedcli   INTEGER NOT NULL,
    cantidad        INTEGER,
    precio          INTEGER,
    oid_pedcli      INTEGER,
    oid_prod        INTEGER,
    PRIMARY KEY ( oid_linpedcli ),
    FOREIGN KEY ( oid_pedcli ) REFERENCES pedidocliente,
    FOREIGN KEY (oid_prod) REFERENCES producto
);

CREATE TABLE proveedor (
    oid_prov     INTEGER NOT NULL,
    cif         CHAR(9) UNIQUE NOT NULL,
    nombre      VARCHAR(30) UNIQUE NOT NULL,
    direccion   VARCHAR(50),
    telefono    NUMBER(9),
    email       VARCHAR(50),
    PRIMARY KEY ( oid_prov )
);

CREATE TABLE pedidoproveedor (
    oid_pedprov   INTEGER NOT NULL,
    fechapedido   TIMESTAMP (0) WITH TIME ZONE NOT NULL,
    fechapago     TIMESTAMP (0) WITH TIME ZONE,                     -- Función actualizar en paquete
    costetotal    INTEGER,                                          -- Misma funcion que pedidocliente
    oid_prov      INTEGER NOT NULL,
    oid_emp       INTEGER NOT NULL,
    PRIMARY KEY ( oid_pedprov ),
    FOREIGN KEY ( oid_prov ) REFERENCES proveedor,
    FOREIGN KEY ( oid_emp ) REFERENCES empleado

);

CREATE TABLE material (
    oid_mat          INTEGER NOT NULL,
    nombre           VARCHAR(50) UNIQUE,
    stock            INTEGER,
    PRIMARY KEY ( oid_mat )
);

CREATE TABLE lineapedidoproveedor (
    oid_linpedprov   INTEGER NOT NULL,
    cantidad         INTEGER,
    precio           INTEGER,
    oid_pedprov      INTEGER,
    oid_mat          INTEGER ,
    anadido         INTEGER DEFAULT 0,
    PRIMARY KEY ( oid_linpedprov ),
    FOREIGN KEY ( oid_pedprov ) REFERENCES pedidoproveedor,
    FOREIGN KEY ( oid_mat ) REFERENCES material    
);


CREATE TABLE camion (
    oid_cam   INTEGER NOT NULL,
    matricula    VARCHAR(7) UNIQUE NOT NULL,
    PRIMARY KEY ( oid_cam )
);

CREATE TABLE cogecamion (
    oid_cogeca         INTEGER NOT NULL,
    fechainicio        TIMESTAMP (0) WITH TIME ZONE,
    fechafin           TIMESTAMP (0) WITH TIME ZONE,                     -- Función actualizar en paquete
    oid_emp            INTEGER,                                          -- IMPORTANTE: UN CAMIONERO NO PUEDE COGER UN CAMION QUE YA ESTÉ EN USO.
    oid_cam            INTEGER,
    PRIMARY KEY ( oid_cogeca ),
    FOREIGN KEY ( oid_emp ) REFERENCES empleado,
    FOREIGN KEY ( oid_cam ) REFERENCES camion
);

-- CONSTRAINTS
ALTER TABLE producto ADD CONSTRAINT ck_longitud_producto CHECK(longitud>0); --
ALTER TABLE producto ADD CONSTRAINT ck_precio_producto CHECK(precio>=0); --
ALTER TABLE producto ADD CONSTRAINT ck_profundidad_producto CHECK(profundidad>0); --
ALTER TABLE producto ADD CONSTRAINT ck_altura_producto CHECK(altura>0);
ALTER TABLE material ADD CONSTRAINT ck_stockpositivo CHECK (stock > 0);
ALTER TABLE nomina ADD CONSTRAINT ck_mes_nomina CHECK (mes > 0 AND mes <= 12);
ALTER TABLE nomina ADD CONSTRAINT ck_año_nomina CHECK (año > 1900 AND año <= 2100);
ALTER TABLE nomina ADD CONSTRAINT ck_salario CHECK (salario > 0);
ALTER TABLE empleado ADD CONSTRAINT ck_capitalsocial CHECK (capitalsocial  >= 3000);
ALTER TABLE empleado ADD CONSTRAINT ck_diasvacaciones CHECK (diasvacaciones  >= 0);
ALTER TABLE empleado ADD CONSTRAINT ck_dni_empleado CHECK (REGEXP_LIKE(dni, '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]'));
ALTER TABLE empleado ADD CONSTRAINT ck_telefono_empleado CHECK (REGEXP_LIKE(telefono, '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]'));
ALTER TABLE camion ADD CONSTRAINT ck_matricula_camion CHECK (REGEXP_LIKE(matricula, '[0-9][0-9][0-9][0-9][A-Z][A-Z][A-Z]'));
ALTER TABLE cliente ADD CONSTRAINT ck_cif_cliente CHECK (REGEXP_LIKE(cif, '[A-Z][0-9][0-9][0-9][0-9][0-9][0-9][0-9]([0-9]|[A-Z])'));
ALTER TABLE cliente ADD CONSTRAINT ck_telefono_cliente CHECK (REGEXP_LIKE(telefono, '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]'));
ALTER TABLE cliente ADD CONSTRAINT ck_correo_cliente CHECK (email LIKE '_%@%_.__%');
ALTER TABLE proveedor ADD CONSTRAINT ck_cif_proveedor CHECK (REGEXP_LIKE(cif, '[A-Z][0-9][0-9][0-9][0-9][0-9][0-9][0-9]([0-9]|[A-Z])'));
ALTER TABLE proveedor ADD CONSTRAINT ck_telefono_proveedor CHECK (REGEXP_LIKE(telefono, '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]'));
ALTER TABLE proveedor ADD CONSTRAINT ck_correo_proveedor CHECK (REGEXP_LIKE (email,'^[A-Za-z]+[A-Za-z0-9.]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$'));
ALTER TABLE lineapedidocliente ADD CONSTRAINT ck_cantidad_lineapedidocliente CHECK(cantidad>0);
ALTER TABLE lineapedidocliente ADD CONSTRAINT ck_precio_lineapedidocliente CHECK(precio>=0);
ALTER TABLE lineapedidoproveedor ADD CONSTRAINT ck_cantidad_lineapedidoprov CHECK(cantidad>0);
ALTER TABLE lineapedidoproveedor ADD CONSTRAINT ck_precio_lineapedidoprov CHECK(precio>=0);
ALTER TABLE pedidoproveedor ADD CONSTRAINT ck_costeTotal_pedidoproveedor CHECK(costeTotal>=0);
ALTER TABLE pedidocliente ADD CONSTRAINT ck_costeTotal_pedidocliente CHECK(costeTotal>=0);


DROP SEQUENCE incrementa_oid_emp;
DROP SEQUENCE incrementa_oid_peticiondias;
DROP SEQUENCE incrementa_oid_jefemaq;
DROP SEQUENCE incrementa_oid_nom;
DROP SEQUENCE incrementa_oid_cli;
DROP SEQUENCE incrementa_oid_pedcli;
DROP SEQUENCE incrementa_oid_linpedcli;
DROP SEQUENCE incrementa_oid_prod;
DROP SEQUENCE incrementa_oid_prov;
DROP SEQUENCE incrementa_oid_pedprov;
DROP SEQUENCE incrementa_oid_linpedprov;
DROP SEQUENCE incrementa_oid_mat;
DROP SEQUENCE incrementa_oid_cam;
DROP SEQUENCE incrementa_oid_cogeca;
DROP SEQUENCE incrementa_oid_maq;

CREATE SEQUENCE incrementa_oid_emp INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_peticiondias INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_jefemaq INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_nom INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_cli INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_pedcli INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_linpedcli INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_prod INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_prov INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_pedprov INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_linpedprov INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_mat INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_cam INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_cogeca INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE SEQUENCE incrementa_oid_maq INCREMENT BY 1 START WITH 1 MAXVALUE 999999 CYCLE;/

CREATE OR REPLACE TRIGGER genera_PK_empleado_BI
    BEFORE INSERT ON empleado FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_emp.NEXTVAL INTO :NEW.OID_emp FROM DUAL;
    END;
    /
    
    CREATE OR REPLACE TRIGGER genera_PK_peticiondias_BI
    BEFORE INSERT ON peticiondias FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_peticiondias.NEXTVAL INTO :NEW.OID_peticiondias FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_jefemaquina_BI
    BEFORE INSERT ON jefemaquina FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_jefemaq.NEXTVAL INTO :NEW.OID_jefemaq FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_nomina_BI
    BEFORE INSERT ON nomina FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_nom.NEXTVAL INTO :NEW.OID_nom FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_cliente_BI
    BEFORE INSERT ON cliente FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_cli.NEXTVAL INTO :NEW.OID_cli FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_pedidocliente_BI
    BEFORE INSERT ON pedidocliente FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_pedcli.NEXTVAL INTO :NEW.OID_pedcli FROM DUAL;
        SELECT CURRENT_TIMESTAMP INTO :NEW.fechapedido FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_linpedcli_BI
    BEFORE INSERT ON lineapedidocliente FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_linpedcli.NEXTVAL INTO :NEW.OID_linpedcli FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_producto_BI
    BEFORE INSERT ON producto FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_prod.NEXTVAL INTO :NEW.OID_prod FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_proveedor_BI
    BEFORE INSERT ON proveedor FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_prov.NEXTVAL INTO :NEW.OID_prov FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_pedidoproveedor_BI
    BEFORE INSERT ON pedidoproveedor FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_pedprov.NEXTVAL INTO :NEW.OID_pedprov FROM DUAL;
        SELECT CURRENT_TIMESTAMP INTO :NEW.fechapedido FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_linpedprov_BI
    BEFORE INSERT ON lineapedidoproveedor FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_linpedprov.NEXTVAL INTO :NEW.OID_linpedprov FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_material_BI
    BEFORE INSERT ON material FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_mat.NEXTVAL INTO :NEW.OID_mat FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_camion_BI
    BEFORE INSERT ON camion FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_cam.NEXTVAL INTO :NEW.OID_cam FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_cogecamion_BI
    BEFORE INSERT ON cogecamion FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_cogeca.NEXTVAL INTO :NEW.OID_cogeca FROM DUAL;
        SELECT CURRENT_TIMESTAMP INTO :NEW.fechainicio FROM DUAL;
    END;
    /
CREATE OR REPLACE TRIGGER genera_PK_maquina_BI
    BEFORE INSERT ON maquina FOR EACH ROW
    BEGIN
        SELECT incrementa_oid_maq.NEXTVAL INTO :NEW.OID_maq FROM DUAL;
    END;
    /



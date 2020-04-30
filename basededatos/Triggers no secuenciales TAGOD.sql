--RN04
CREATE OR REPLACE TRIGGER stockMinimo_AIU
    AFTER INSERT OR UPDATE OF stock ON material
    FOR EACH ROW
BEGIN
    IF :NEW.stock < 1500
    THEN DBMS_OUTPUT.PUT_LINE('¡ATENCIÓN! El stock actual del material "'||:NEW.nombre||'" es de '||:NEW.stock||' unidades. Se debe realizar un pedido de material.');
    END IF;
END;
/
--RN15
CREATE OR REPLACE TRIGGER jefeMaquina_AI
    AFTER INSERT OR UPDATE ON empleado
    FOR EACH ROW
BEGIN
    IF :NEW.cargo = 9 and :new.oid_maq is not null THEN
        INSERT INTO jefeMaquina (oid_emp, oid_maq) VALUES (:NEW.oid_emp, :NEW.oid_maq);
    END IF;
EXCEPTION
    WHEN DUP_VAL_ON_INDEX THEN
    RAISE_APPLICATION_ERROR(-20100, 'No puede haber 2 jefes en una sola máquina. Error provocado por el empleado: '||:NEW.nombre||' '||:NEW.apellidos);
    
END;
/
--RN14
CREATE OR REPLACE TRIGGER maquinaAsignada_AI
    BEFORE INSERT ON empleado
    FOR EACH ROW
DECLARE 
w_cargo cargo.rol%TYPE;
BEGIN
    SELECT rol INTO w_cargo FROM cargo WHERE oid_cargo = :NEW.cargo;

    IF (:NEW.cargo between 1 and 8 OR :NEW.cargo = 11) AND (:NEW.oid_maq is not null) THEN
        RAISE_APPLICATION_ERROR(-20102, 'Sólo los peones y jefes de máquina pueden trabajar en una máquina. Error provocado por el empleado: '||:NEW.nombre||' '||:NEW.apellidos||' con cargo: '||w_cargo);
    END IF;
END;
/
--RN09A
CREATE OR REPLACE TRIGGER precioPedido_AIU
    AFTER INSERT OR UPDATE OR DELETE  ON lineaPedidoCliente
BEGIN
    UPDATE pedidoCliente SET costetotal = precio_pedCli(oid_pedcli);
END;
/
--RN08
CREATE OR REPLACE TRIGGER precioProveedor_AIU
    AFTER INSERT OR UPDATE OR DELETE  ON lineaPedidoProveedor
BEGIN
    UPDATE pedidoProveedor SET costetotal = precio_pedProv(oid_pedprov);
END;
/ 

CREATE OR REPLACE TRIGGER precioproducto
    BEFORE INSERT OR UPDATE ON lineaPedidoCliente
    FOR EACH ROW
DECLARE
    w_precio producto.precio%TYPE;
   
BEGIN
    SELECT precio INTO w_precio FROM producto WHERE producto.oid_prod = :NEW.oid_prod;
    SELECT w_precio INTO :NEW.precio FROM DUAL;

END;
/
CREATE OR REPLACE TRIGGER ckFechasPC_BIU
    BEFORE INSERT OR UPDATE OF fechapedido,fechafinfabricacion,fechaenvio,fechallegada,fechapago ON pedidocliente
    FOR EACH ROW
    BEGIN
    IF :NEW.fechafinfabricacion <= :NEW.fechapedido THEN
        RAISE_APPLICATION_ERROR(-20104,'La fecha de fin de fabricación no puede ser menor que la fecha de pedido');
    END IF;
    IF :NEW.fechaenvio <= :NEW.fechafinfabricacion THEN
        RAISE_APPLICATION_ERROR(-20104,'La fecha de envío no puede ser menor que la fecha de fabricación');
        END IF;
    IF :NEW.fechallegada <= :NEW.fechaenvio THEN
        RAISE_APPLICATION_ERROR(-20104,'La fecha de llegada no puede ser menor que la fecha de envío');
    END IF;
    IF :NEW.fechapago <= :NEW.fechapedido THEN
        RAISE_APPLICATION_ERROR(-20104,'La fecha de pago no puede ser menor que la fecha de pedido');
    END IF;
END;
/

CREATE OR REPLACE TRIGGER ckFechasPP_BIU
    BEFORE INSERT OR UPDATE OF fechapedido,fechapago ON pedidoproveedor
    FOR EACH ROW
    BEGIN
    IF :NEW.fechapago <= :NEW.fechapedido THEN
        RAISE_APPLICATION_ERROR(-20104,'La fecha de pago no puede ser menor que la fecha de pedido');
    END IF;
   
END;
/
--RN03
CREATE OR REPLACE TRIGGER distanciaFechasPedCli_BIU
    BEFORE INSERT OR UPDATE ON pedidoCliente
    FOR EACH ROW
    BEGIN
    IF :NEW.fechafinfabricacion IS NULL AND SYSTIMESTAMP - :NEW.fechapedido > 1 THEN
        DBMS_OUTPUT.PUT_LINE('¡ATENCIÓN! El pedido con fecha "'||:NEW.fechapedido||'" y coste total "'||:NEW.costetotal||'" debe ser enviado inmediatamente.');
    END IF;
END;
/
--RN07
CREATE OR REPLACE TRIGGER distanciaFechasPedCliPago_BIU
    BEFORE INSERT OR UPDATE ON pedidoCliente
    FOR EACH ROW
    BEGIN
    IF :NEW.fechapago IS NULL AND SYSTIMESTAMP - :NEW.fechallegada > 7 THEN
        DBMS_OUTPUT.PUT_LINE('¡ATENCIÓN! El pedido del cliente "'||:NEW.oid_cli||'" y coste total "'||:NEW.costetotal||'" debe ser pagado inmediatamente.');
    END IF;
END;
/
CREATE OR REPLACE TRIGGER ckFechasCC_BIU
    BEFORE INSERT OR UPDATE OF fechainicio,fechafin ON cogecamion
    FOR EACH ROW
    BEGIN
    IF :NEW.fechafin <= :NEW.fechainicio THEN
        RAISE_APPLICATION_ERROR(-20104,'La fecha de fin no puede ser menor que la fecha de inicio');
    END IF;
   
END;
/
--RN02
CREATE OR REPLACE TRIGGER camioneroNoCualificado
    BEFORE INSERT OR UPDATE ON cogeCamion
    FOR EACH ROW
DECLARE
    w_nombre empleado.nombre%TYPE;
    w_apellidos empleado.apellidos%TYPE;
    w_cargo empleado.cargo%TYPE;
    w_rol cargo.rol%TYPE;
BEGIN
    SELECT cargo INTO w_cargo FROM empleado WHERE empleado.oid_emp = :NEW.oid_emp;
    SELECT nombre INTO w_nombre FROM empleado WHERE empleado.oid_emp = :NEW.oid_emp;
    SELECT apellidos INTO w_apellidos FROM empleado WHERE empleado.oid_emp = :NEW.oid_emp;
    SELECT rol INTO w_rol FROM cargo WHERE cargo.oid_cargo = w_cargo;
    IF w_cargo != 11 THEN
        RAISE_APPLICATION_ERROR(-20105,'Sólo los camioneros pueden conducir un camión. Error provocado por el empleado: '||w_nombre||' '||w_apellidos||', con cargo: '||w_rol||'.');     
    END IF;
END;
/
--RN13
CREATE OR REPLACE TRIGGER cargoUnico_BIU
    BEFORE INSERT ON empleado
    FOR EACH ROW
DECLARE
yaExiste INT := 0;
w_nombre empleado.nombre%TYPE;
w_apellido empleado.apellidos%TYPE;
w_rol cargo.rol%TYPE;
BEGIN

    SELECT count(*) INTO yaExiste FROM empleado WHERE empleado.cargo = :NEW.cargo;
    IF((:NEW.cargo BETWEEN 1 AND 6 OR :NEW.cargo = 8)  AND yaExiste <> 0) THEN 
    SELECT nombre,apellidos INTO w_nombre,w_apellido FROM empleado WHERE :NEW.cargo = empleado.cargo;
    SELECT rol INTO w_rol FROM cargo WHERE cargo.oid_cargo = :NEW.cargo;
    RAISE_APPLICATION_ERROR(-20103, 'El empleado '||:NEW.nombre||' '||:NEW.apellidos||' no puede tener el cargo  '||w_rol||' porque ya lo tiene '||w_nombre||' '||w_apellido||'');
    END IF;
END;
/
--RN05
CREATE OR REPLACE TRIGGER nogerentedecompra
    BEFORE INSERT OR UPDATE of oid_emp ON PEDIDOPROVEEDOR
    FOR EACH ROW
DECLARE
    w_nombre empleado.nombre%TYPE;
    w_apellidos empleado.apellidos%TYPE;
    w_cargo empleado.cargo%TYPE;
    w_rol cargo.rol%TYPE;
BEGIN
    SELECT cargo INTO w_cargo FROM empleado WHERE empleado.oid_emp = :NEW.oid_emp;
    SELECT nombre INTO w_nombre FROM empleado WHERE empleado.oid_emp = :NEW.oid_emp;
    SELECT apellidos INTO w_apellidos FROM empleado WHERE empleado.oid_emp = :NEW.oid_emp;
    SELECT rol INTO w_rol FROM cargo WHERE cargo.oid_cargo = w_cargo;
    IF w_cargo != 6 THEN
        RAISE_APPLICATION_ERROR(-20105,'Sólo los gerentes de compras pueden realizar un pedido a proveedor. Error provocado por el empleado: '||w_nombre||' '||w_apellidos||', con cargo: '||w_rol||'.');     
    END IF;
END;
/
--RN12
CREATE OR REPLACE TRIGGER nogerentedeventas
    BEFORE INSERT OR UPDATE of oid_emp ON PEDIDOCLIENTE
    FOR EACH ROW
DECLARE
    w_nombre empleado.nombre%TYPE;
    w_apellidos empleado.apellidos%TYPE;
    w_cargo empleado.cargo%TYPE;
    w_rol cargo.rol%TYPE;
BEGIN
    SELECT cargo INTO w_cargo FROM empleado WHERE empleado.oid_emp = :NEW.oid_emp;
    SELECT nombre INTO w_nombre FROM empleado WHERE empleado.oid_emp = :NEW.oid_emp;
    SELECT apellidos INTO w_apellidos FROM empleado WHERE empleado.oid_emp = :NEW.oid_emp;
    SELECT rol INTO w_rol FROM cargo WHERE cargo.oid_cargo = w_cargo;
    IF w_cargo != 5 THEN
        RAISE_APPLICATION_ERROR(-20105,'Sólo los gerentes de compras pueden realizar un pedido a proveedor. Error provocado por el empleado: '||w_nombre||' '||w_apellidos||', con cargo: '||w_rol||'.');     
    END IF;
END;
/
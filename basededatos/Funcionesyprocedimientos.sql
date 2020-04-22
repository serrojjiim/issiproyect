CL SCR;
SET SERVEROUTPUT ON;
--####################################################################################
--                             FUNCIONES
--####################################################################################

-- RF-001: Pedidos pendientes de fabricar
SELECT * FROM pedidocliente WHERE fechafinfabricacion IS NULL ORDER BY fechaenvio;
-- RF-002:
SELECT * FROM pedidocliente WHERE fechaenvio <= SYSDATE and fechapago is null;
-- RF-003.1: Pedidos realizados
SELECT * FROM pedidoproveedor;
-- RF-003.2: Pedidos pendientes de pago
SELECT * FROM pedidoproveedor WHERE fechapago is null;
-- RF-004: nominasmensuales
SELECT * FROM nomina WHERE mes = EXTRACT(MONTH FROM SYSDATE);


-- Funciones auxiliares para RF-005
CREATE OR REPLACE FUNCTION precio_pedCli (oid_pedido NUMBER)
RETURN NUMBER IS precio_total NUMBER;
BEGIN
    SELECT SUM(precio*cantidad) INTO precio_total FROM lineapedidocliente WHERE oid_pedido = lineapedidocliente.oid_pedcli;
RETURN (precio_total);
END;
/

CREATE OR REPLACE FUNCTION precio_pedProv (oid_pedido NUMBER)
RETURN NUMBER IS precio_total NUMBER;
BEGIN
    SELECT SUM(precio*cantidad) INTO precio_total FROM lineapedidoproveedor WHERE oid_pedido = lineapedidoproveedor.oid_pedprov;
RETURN (precio_total);
END;
/

-- RF-005: Capital actual de la empresa
CREATE OR REPLACE FUNCTION capitalActual
RETURN INTEGER
IS  balance INTEGER;
    costeNomina nomina.salario%TYPE;
    costeProveedor pedidoproveedor.costeTotal%TYPE;
    ingresoCliente pedidocliente.costeTotal%TYPE;
	capitalAportado empleado.capitalSocial%TYPE;
BEGIN
    SELECT SUM(salario) INTO costeNomina FROM nomina;
    SELECT SUM(costeTotal) INTO costeProveedor FROM pedidoProveedor;
    SELECT SUM(costeTotal) INTO ingresoCliente FROM pedidoCliente;
    SELECT SUM(capitalSocial) INTO capitalAportado FROM empleado;
    balance := (ingresoCliente + capitalAportado) - (costeNomina + costeProveedor);
RETURN (balance);
END;
/

SELECT capitalActual FROM DUAL;

-- RF-007: Lista de m�quinas con su jefe de m�quina y empleados trabajando en ella
SELECT maquina.nombre Maquina, cargo.rol Cargo, empleado.apellidos Apellidos, empleado.nombre Nombre FROM empleado, maquina, cargo
WHERE maquina.oid_maq = empleado.oid_maq AND empleado.cargo = cargo.oid_cargo AND empleado.cargo = 9
        UNION
SELECT maquina.nombre Maquina, cargo.rol Cargo, empleado.apellidos Apellidos, empleado.nombre Nombre FROM empleado, maquina, cargo
WHERE maquina.oid_maq = empleado.oid_maq AND empleado.cargo != 9 AND empleado.cargo = cargo.oid_cargo ORDER BY maquina;

-- RF-008: Lista de peones sin m�quina asignada
SELECT * FROM empleado WHERE oid_maq IS NULL AND cargo IN(10);
-- RF-012: Lista de materiales con su stock
SELECT nombre, stock FROM material;
-- RF-013: Lista de proveedores
SELECT * FROM proveedor;
-- RF-016: Lista de clientes
SELECT * FROM cliente;
-- RF-018: D�as de vacaciones de un empleado dado
CREATE OR REPLACE FUNCTION diasVacacionesEmpleado (nom varchar2, ape varchar2)
RETURN INTEGER IS res INTEGER;
BEGIN
 	SELECT diasvacaciones INTO res FROM empleado WHERE nombre = nom AND apellidos = ape;
RETURN res;
END;
/

--####################################################################################
--                             PROCEDIMIENTOS
--####################################################################################

CREATE OR REPLACE PROCEDURE finFab (W_FECHAPEDIDO IN PEDIDOCLIENTE.FECHAPEDIDO%TYPE, W_OID_CLI IN PEDIDOCLIENTE.OID_CLI%TYPE)
AS w_cliente cliente.nombre%TYPE;
BEGIN
    SELECT nombre into w_cliente FROM cliente where oid_cli = w_oid_cli; 
    UPDATE PEDIDOCLIENTE
    SET fechafinfabricacion = SYSTIMESTAMP WHERE oid_cli = w_oid_cli and fechapedido = w_fechapedido;
    COMMIT WORK;
    DBMS_OUTPUT.PUT_LINE('Fecha de fin de fabricaci�n del pedido del cliente '||w_cliente||' actualizada.');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('No se ha podido ejecutar correctamente el proceso: "finFab".');
    ROLLBACK;
END finFab;
/

CREATE OR REPLACE PROCEDURE envioPedido (W_FECHAPEDIDO IN PEDIDOCLIENTE.FECHAPEDIDO%TYPE, W_OID_CLI IN PEDIDOCLIENTE.OID_CLI%TYPE)
AS w_cliente cliente.nombre%TYPE;
BEGIN
    SELECT nombre into w_cliente FROM cliente where oid_cli = w_oid_cli; 
    UPDATE PEDIDOCLIENTE
    SET fechaenvio = SYSTIMESTAMP WHERE oid_cli = w_oid_cli and fechapedido = w_fechapedido;
    COMMIT WORK;
    DBMS_OUTPUT.PUT_LINE('Fecha de env�o del pedido del cliente '||w_cliente||' actualizada.');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('No se ha podido ejecutar correctamente el proceso: "envioPedido".');
    ROLLBACK;
END envioPedido;
/

CREATE OR REPLACE PROCEDURE pedidoRecibidoCliente (W_FECHAPEDIDO IN PEDIDOCLIENTE.FECHAPEDIDO%TYPE, W_OID_CLI IN PEDIDOCLIENTE.OID_CLI%TYPE)
AS w_cliente cliente.nombre%TYPE;
BEGIN
    SELECT nombre into w_cliente FROM cliente where oid_cli = w_oid_cli; 
    UPDATE PEDIDOCLIENTE
    SET fechallegada = SYSTIMESTAMP WHERE oid_cli = w_oid_cli and fechapedido = w_fechapedido;
    COMMIT WORK;
    DBMS_OUTPUT.PUT_LINE('Fecha de llegada del pedido del cliente '||w_cliente||' actualizada.');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('No se ha podido ejecutar correctamente el proceso: "pedidoRecibidoCliente".');
    ROLLBACK;
END pedidoRecibidoCliente;
/

CREATE OR REPLACE PROCEDURE ACTUALIZARCARGO (W_OID_EMP IN EMPLEADO.OID_EMP%TYPE,W_CARGO IN EMPLEADO.CARGO%TYPE)
AS
    SALIDA BOOLEAN :=TRUE;
    TIPO_EMPLEADO EMPLEADO%ROWTYPE;
    yaExiste INT := 0;
    CARGOA EMPLEADO.CARGO%TYPE;
    
BEGIN
    SELECT count(*) INTO yaExiste FROM empleado WHERE empleado.cargo = w_cargo;
    IF((w_cargo BETWEEN 1 AND 6 OR w_cargo = 8)  AND yaExiste <> 0) THEN 
    RAISE_APPLICATION_ERROR(-20103, 'El empleado no puede tener el cargo  '||w_cargo||'');
    END IF;
    SELECT CARGO INTO CARGOA FROM EMPLEADO WHERE OID_EMP=W_OID_EMP;
    IF(w_cargo BETWEEN 1 AND 8  OR W_CARGO = 11) THEN 
    UPDATE EMPLEADO 
    SET OID_MAQ = NULL WHERE OID_EMP = W_OID_EMP;
    END IF;
    UPDATE EMPLEADO
    SET CARGO = W_CARGO WHERE W_OID_EMP = OID_EMP;
    IF CARGOA = 9 AND W_CARGO <> 9 THEN
    DELETE JEFEMAQUINA WHERE W_OID_EMP = OID_EMP;
    END IF;
    SELECT * INTO TIPO_EMPLEADO FROM EMPLEADO WHERE W_OID_EMP = OID_EMP;
    COMMIT WORK;
    DBMS_OUTPUT.PUT_LINE('Cargo del empleado '||TIPO_EMPLEADO.NOMBRE||' '||TIPO_EMPLEADO.APELLIDOS||' actualizado.');
EXCEPTION
    WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('Se ha producido un error al actualizar el cargo del empleado '||TIPO_EMPLEADO.NOMBRE||' '||TIPO_EMPLEADO.APELLIDOS||' ');
    
END ACTUALIZARCARGO;
/
--ACTUALIZAR MAQUINA EN EMPLEADO
CREATE OR REPLACE PROCEDURE ACTUALIZARMAQUINA (W_OID_EMP IN EMPLEADO.OID_EMP%TYPE,W_MAQUINA IN EMPLEADO.OID_MAQ%TYPE)
AS
    SALIDA BOOLEAN :=TRUE;
    TIPO_EMPLEADO EMPLEADO%ROWTYPE;
    yaExiste INT := 0;
    yaExiste1 INT := 0;

    
BEGIN
    SELECT * INTO TIPO_EMPLEADO FROM EMPLEADO WHERE W_OID_EMP = OID_EMP;

    SELECT count(*) INTO yaExiste FROM empleado WHERE empleado.cargo = tipo_empleado.cargo and empleado.oid_maq = w_maquina;
    IF(tipo_empleado.cargo = 9 and yaExiste <> 0 ) THEN 
    RAISE_APPLICATION_ERROR(-20103, 'No puede haber dos jefes de m�quinas en la misma m�quina');
    END IF;
    
    UPDATE EMPLEADO 
    SET OID_MAQ = W_MAQUINA WHERE W_OID_EMP = OID_EMP;
    SELECT count(*) INTO yaExiste1 FROM jefemaquina WHERE jefemaquina.oid_emp = w_oid_emp;
    IF yaExiste1 <> 0 AND TIPO_EMPLEADO.CARGO = 9  THEN
    UPDATE JEFEMAQUINA
    SET OID_MAQ = W_MAQUINA WHERE W_OID_EMP = OID_EMP;    
    END IF;
    IF yaExiste1 = 0 AND TIPO_EMPLEADO.CARGO = 9 THEN
    INSERT INTO jefemaquina (oid_emp,oid_maq)  values (w_oid_emp,w_maquina); 
    END IF;
    COMMIT WORK;
    DBMS_OUTPUT.PUT_LINE('La maquina asignada al empleado '||TIPO_EMPLEADO.NOMBRE||' '||TIPO_EMPLEADO.APELLIDOS||' se ha actualizado.');
EXCEPTION
    WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('Se ha producido un error al actualizar la m�quina asignada al empleado '||TIPO_EMPLEADO.NOMBRE||' '||TIPO_EMPLEADO.APELLIDOS||' ');
    
END ACTUALIZARMAQUINA;
/
CREATE OR REPLACE PROCEDURE pedidoCobrado (W_FECHAPEDIDO IN PEDIDOCLIENTE.FECHAPEDIDO%TYPE, W_OID_CLI IN PEDIDOCLIENTE.OID_CLI%TYPE)
AS w_cliente cliente.nombre%TYPE;
BEGIN
    SELECT nombre into w_cliente FROM cliente where oid_cli = w_oid_cli; 
    UPDATE PEDIDOCLIENTE
    SET fechapago = SYSTIMESTAMP WHERE oid_cli = w_oid_cli and fechapedido = w_fechapedido;
    COMMIT WORK;
    DBMS_OUTPUT.PUT_LINE('Fecha de pago del pedido del cliente '||w_cliente||' actualizada.');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('No se ha podido ejecutar correctamente el proceso: "pedidoCobrado".');
    ROLLBACK;
END pedidoCobrado;
/

CREATE OR REPLACE PROCEDURE pagoProveedor (W_FECHAPEDIDO IN PEDIDOPROVEEDOR.FECHAPEDIDO%TYPE, W_OID_PROV IN PEDIDOPROVEEDOR.OID_PROV%TYPE)
AS w_proveedor proveedor.nombre%TYPE;
BEGIN
    SELECT nombre into w_proveedor FROM proveedor where oid_prov = w_oid_prov; 
    UPDATE PEDIDOPROVEEDOR
    SET fechapago = SYSTIMESTAMP WHERE oid_prov = w_oid_prov and fechapedido = w_fechapedido;
    COMMIT WORK;
    DBMS_OUTPUT.PUT_LINE('Fecha de pago al proveedor '||w_proveedor||' actualizada.');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('No se ha podido ejecutar correctamente el proceso: "pagoProveedor".');
    ROLLBACK;
END pagoProveedor;
/

CREATE OR REPLACE PROCEDURE finCogeCamion (W_FECHAINICIO IN COGECAMION.FECHAINICIO%TYPE, W_MATRICULA IN CAMION.MATRICULA%TYPE)
AS  w_empleado cliente.nombre%TYPE;
    w_camion camion.oid_cam%TYPE;
    w_cogeca cogecamion.oid_emp%TYPE;
BEGIN
    SELECT oid_cam into w_camion FROM camion WHERE matricula = w_matricula;
    SELECT oid_emp into w_cogeca FROM cogecamion where w_camion = oid_cam and fechainicio = w_fechainicio; 
    SELECT nombre into w_empleado FROM empleado where oid_emp = w_cogeca; 
    UPDATE COGECAMION
    SET FECHAFIN = SYSTIMESTAMP WHERE oid_cam = w_camion and fechainicio = w_fechainicio;
    DBMS_OUTPUT.PUT_LINE('El cami�n con matr�cula '||w_matricula||' y conducido por '||w_empleado||', ha finalizado su trayecto.');
    COMMIT WORK;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('No se ha podido ejecutar correctamente el proceso: "finCogeCamion".');
    ROLLBACK;
END finCogeCamion;
/

CREATE OR REPLACE PROCEDURE muestraNominas(w_mes NUMBER, w_a�o NUMBER) AS
    cursor c is (SELECT nomina.salario, empleado.nombre, empleado.apellidos FROM nomina NATURAL JOIN empleado WHERE mes = w_mes and a�o = w_a�o) ORDER BY empleado.apellidos, empleado.nombre;
BEGIN
    DBMS_OUTPUT.PUT_LINE('Las n�minas son: ');
    DBMS_OUTPUT.PUT_LINE('Salario      Empleado');
        FOR fila IN c LOOP
            EXIT WHEN c%NOTFOUND;
                DBMS_OUTPUT.PUT_LINE(' '||fila.salario||'        '||fila.apellidos||', '||fila.nombre);
        END LOOP;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('No se ha podido ejecutar correctamente el proceso: "muestraNominas".');
    ROLLBACK;
END muestraNominas;
/

CREATE OR REPLACE PROCEDURE muestraNominasPorEmpleado(w_dni in empleado.dni%type) AS
    cursor c is (SELECT nomina.salario,nomina.mes,nomina.a�o, empleado.nombre, empleado.apellidos FROM nomina NATURAL JOIN empleado WHERE dni = w_dni) ORDER BY empleado.apellidos, empleado.nombre;
BEGIN
    DBMS_OUTPUT.PUT_LINE('Las n�minas son: ');
    DBMS_OUTPUT.PUT_LINE('Salario      Mes      A�o        Empleado');
        FOR fila IN c LOOP
            EXIT WHEN c%NOTFOUND;
                DBMS_OUTPUT.PUT_LINE(' '||fila.salario||'         '||fila.mes||'       '||fila.a�o||'       '||fila.apellidos||', '||fila.nombre);
        END LOOP;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('No se ha podido ejecutar correctamente el proceso: "muestraNominas".');
    ROLLBACK;
END muestraNominasPorEmpleado;
/
--RF-014
CREATE OR REPLACE PROCEDURE NuevoPedidoProveedor (W_OID_EMP IN PEDIDOPROVEEDOR.OID_EMP%TYPE, W_OID_PROV IN PEDIDOPROVEEDOR.OID_PROV%TYPE)
AS  
BEGIN
    INSERT INTO pedidoproveedor (fechapedido, fechapago, costetotal, oid_prov , oid_emp) VALUES (SYSTIMESTAMP, NULL, 0, W_OID_PROV,W_OID_EMP);
END NuevoPedidoProveedor;
/
--RF-015
CREATE OR REPLACE PROCEDURE nuevoPedidoCliente (W_OID_EMP IN PEDIDOCLIENTE.OID_EMP%TYPE, W_OID_CLI IN PEDIDOCLIENTE.OID_CLI%TYPE)
AS  
BEGIN
    INSERT INTO pedidocliente(fechapedido, fechafinfabricacion, fechaenvio, fechallegada, fechapago, costetotal,oid_cli,oid_emp) VALUES (SYSTIMESTAMP, NULL,NULL,NULL,NULL, 0, W_OID_CLI,W_OID_EMP);
END nuevoPedidoCliente;
/

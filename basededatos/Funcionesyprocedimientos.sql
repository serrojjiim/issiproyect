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

-- RF-007: Lista de máquinas con su jefe de máquina y empleados trabajando en ella
SELECT maquina.nombre Maquina, cargo.rol Cargo, empleado.apellidos Apellidos, empleado.nombre Nombre FROM empleado, maquina, cargo
WHERE maquina.oid_maq = empleado.oid_maq AND empleado.cargo = cargo.oid_cargo AND empleado.cargo = 9
        UNION
SELECT maquina.nombre Maquina, cargo.rol Cargo, empleado.apellidos Apellidos, empleado.nombre Nombre FROM empleado, maquina, cargo
WHERE maquina.oid_maq = empleado.oid_maq AND empleado.cargo != 9 AND empleado.cargo = cargo.oid_cargo ORDER BY maquina;

-- RF-008: Lista de peones sin máquina asignada
SELECT * FROM empleado WHERE oid_maq IS NULL AND cargo IN(10);
-- RF-012: Lista de materiales con su stock
SELECT nombre, stock FROM material;
-- RF-013: Lista de proveedores
SELECT * FROM proveedor;
-- RF-016: Lista de clientes
SELECT * FROM cliente;
-- RF-018: Días de vacaciones de un empleado dado
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
    DBMS_OUTPUT.PUT_LINE('Fecha de fin de fabricación del pedido del cliente '||w_cliente||' actualizada.');
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
    DBMS_OUTPUT.PUT_LINE('Fecha de envío del pedido del cliente '||w_cliente||' actualizada.');
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
    DBMS_OUTPUT.PUT_LINE('El camión con matrícula '||w_matricula||' y conducido por '||w_empleado||', ha finalizado su trayecto.');
    COMMIT WORK;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('No se ha podido ejecutar correctamente el proceso: "finCogeCamion".');
    ROLLBACK;
END finCogeCamion;
/

CREATE OR REPLACE PROCEDURE muestraNominas(w_mes NUMBER, w_año NUMBER) AS
    cursor c is (SELECT nomina.salario, empleado.nombre, empleado.apellidos FROM nomina NATURAL JOIN empleado WHERE mes = w_mes and año = w_año) ORDER BY empleado.apellidos, empleado.nombre;
BEGIN
    DBMS_OUTPUT.PUT_LINE('Las nóminas son: ');
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
    cursor c is (SELECT nomina.salario,nomina.mes,nomina.año, empleado.nombre, empleado.apellidos FROM nomina NATURAL JOIN empleado WHERE dni = w_dni) ORDER BY empleado.apellidos, empleado.nombre;
BEGIN
    DBMS_OUTPUT.PUT_LINE('Las nóminas son: ');
    DBMS_OUTPUT.PUT_LINE('Salario      Mes      Año        Empleado');
        FOR fila IN c LOOP
            EXIT WHEN c%NOTFOUND;
                DBMS_OUTPUT.PUT_LINE(' '||fila.salario||'         '||fila.mes||'       '||fila.año||'       '||fila.apellidos||', '||fila.nombre);
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

--Eliminiar empleado

CREATE OR REPLACE PROCEDURE QUITAR_EMPLEADO (DNI_EMP IN EMPLEADO.DNI%TYPE) AS
    TIPO_EMPLEADO EMPLEADO%ROWTYPE;
BEGIN
    SELECT * INTO TIPO_EMPLEADO FROM EMPLEADO WHERE DNI_EMP = DNI;
  IF TIPO_EMPLEADO.CARGO =9 THEN 
  DELETE FROM JEFEMAQUINA WHERE OID_EMP = TIPO_EMPLEADO.OID_EMP;
  END IF;
  --IF (NUM_PRESTAMOS <> 0) THEN
    --RAISE_APPLICATION_ERROR(-206 00,'No se puede quitar el libro porque ya tiene pr?stamos asignados');
 -- ELSE
    DELETE FROM EMPLEADO WHERE DNI = DNI_EMP;
 -- END IF;
END;
/

--ACTUALIZAR MAQUINA EN EMPLEADO
CREATE OR REPLACE PROCEDURE ACTUALIZARMAQUINA (W_DNI_EMP IN EMPLEADO.DNI%TYPE,W_MAQUINA IN EMPLEADO.OID_MAQ%TYPE)
AS
    SALIDA BOOLEAN :=TRUE;
    TIPO_EMPLEADO EMPLEADO%ROWTYPE;
    yaExiste INT := 0;
    yaExiste1 INT := 0;
    w_oid_emp EMPLEADO.OID_EMP%TYPE;
    
BEGIN
    SELECT * INTO TIPO_EMPLEADO FROM EMPLEADO WHERE W_DNI_EMP = DNI;
    SELECT OID_EMP INTO w_oid_emp FROM EMPLEADO WHERE W_DNI_EMP = DNI;
    SELECT count(*) INTO yaExiste FROM empleado WHERE empleado.cargo = tipo_empleado.cargo and empleado.oid_maq = w_maquina;
    IF(tipo_empleado.cargo = 9 and yaExiste <> 0 ) THEN 
    RAISE_APPLICATION_ERROR(-20103, 'No puede haber dos jefes de máquinas en la misma máquina');
    END IF;
    
    UPDATE EMPLEADO 
    SET OID_MAQ = W_MAQUINA WHERE W_DNI_EMP = DNI;
    SELECT count(*) INTO yaExiste1 FROM jefemaquina WHERE jefemaquina.oid_emp = w_oid_emp;
    IF yaExiste1 <> 0 AND TIPO_EMPLEADO.CARGO = 9  THEN
    UPDATE JEFEMAQUINA
    SET OID_MAQ = W_MAQUINA WHERE w_oid_emp = oid_emp;    
    END IF;
    IF yaExiste1 = 0 AND TIPO_EMPLEADO.CARGO = 9 THEN
    INSERT INTO jefemaquina (oid_emp,oid_maq)  values (tipo_empleado.oid_emp,w_maquina); 
    END IF;
    COMMIT WORK;
    DBMS_OUTPUT.PUT_LINE('La maquina asignada al empleado '||TIPO_EMPLEADO.NOMBRE||' '||TIPO_EMPLEADO.APELLIDOS||' se ha actualizado.');
EXCEPTION
    WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('Se ha producido un error al actualizar la máquina asignada al empleado '||TIPO_EMPLEADO.NOMBRE||' '||TIPO_EMPLEADO.APELLIDOS||' ');
    
END ACTUALIZARMAQUINA;
/

CREATE OR REPLACE PROCEDURE ACTUALIZARCARGO (W_DNI_EMP IN EMPLEADO.DNI%TYPE,W_CARGO IN EMPLEADO.CARGO%TYPE)
AS
    SALIDA BOOLEAN :=TRUE;
    TIPO_EMPLEADO EMPLEADO%ROWTYPE;
    yaExiste INT := 0;
    CARGOA EMPLEADO.CARGO%TYPE;
    w_oid_emp EMPLEADO.OID_EMP%TYPE;

BEGIN
    SELECT oid_emp INTO w_oid_emp FROM EMPLEADO WHERE DNI=W_DNI_EMP;
    SELECT count(*) INTO yaExiste FROM empleado WHERE empleado.cargo = w_cargo;
    IF((w_cargo BETWEEN 1 AND 6 OR w_cargo = 8)  AND yaExiste <> 0) THEN 
    RAISE_APPLICATION_ERROR(-20103, 'El empleado no puede tener el cargo  '||w_cargo||'');
    END IF;
    SELECT CARGO INTO CARGOA FROM EMPLEADO WHERE DNI=W_DNI_EMP;
    IF(w_cargo BETWEEN 1 AND 8  OR W_CARGO = 11) THEN 
    UPDATE EMPLEADO 
    SET OID_MAQ = NULL WHERE DNI = W_DNI_EMP;
    END IF;
    UPDATE EMPLEADO
    SET CARGO = W_CARGO WHERE W_DNI_EMP = DNI;
    IF CARGOA = 9 AND W_CARGO <> 9 THEN
    DELETE JEFEMAQUINA WHERE w_oid_emp = OID_EMP;
    END IF;
    SELECT * INTO TIPO_EMPLEADO FROM EMPLEADO WHERE DNI=W_DNI_EMP;
    COMMIT WORK;
    DBMS_OUTPUT.PUT_LINE('Cargo del empleado '||TIPO_EMPLEADO.NOMBRE||' '||TIPO_EMPLEADO.APELLIDOS||' actualizado.');
EXCEPTION
    WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('Se ha producido un error al actualizar el cargo del empleado '||TIPO_EMPLEADO.NOMBRE||' '||TIPO_EMPLEADO.APELLIDOS||' ');
    
END ACTUALIZARCARGO;
/
--ACTUALIZAR DATOS EMPLEADO
CREATE OR REPLACE PROCEDURE ACTUALIZARDATOSPERSONALES (W_OID_EMP IN EMPLEADO.OID_EMP%TYPE,W_DNI_EMP IN EMPLEADO.DNI%TYPE,W_NOMBRE IN EMPLEADO.NOMBRE%TYPE,
W_APELLIDOS IN EMPLEADO.APELLIDOS%TYPE, W_TELEFONO IN EMPLEADO.TELEFONO%TYPE,
W_DIRECCION IN EMPLEADO.DIRECCION%TYPE,W_CAPITALSOCIAL IN EMPLEADO.CAPITALSOCIAL%TYPE, W_FECHACONTRATACION IN EMPLEADO.FECHACONTRATACION%TYPE,
W_DIASVACACIONES IN EMPLEADO.DIASVACACIONES%TYPE)
AS
  
    TIPO_EMPLEADO EMPLEADO%ROWTYPE;
    
BEGIN
    SELECT * INTO TIPO_EMPLEADO FROM EMPLEADO WHERE W_OID_EMP = OID_EMP;
  
    
    UPDATE EMPLEADO 
    SET DNI = W_DNI_EMP, NOMBRE = W_NOMBRE, APELLIDOS = W_APELLIDOS, TELEFONO = W_TELEFONO, DIRECCION = W_DIRECCION, CAPITALSOCIAL = W_CAPITALSOCIAL,
    FECHACONTRATACION = W_FECHACONTRATACION, DIASVACACIONES = W_DIASVACACIONES WHERE W_OID_EMP = OID_EMP;
    COMMIT WORK;
EXCEPTION
    WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('Se ha producido un error al actualizar la máquina asignada al empleado '||TIPO_EMPLEADO.NOMBRE||' '||TIPO_EMPLEADO.APELLIDOS||' ');
    
END ACTUALIZARDATOSPERSONALES;
/


--AÑADIR EMPLEADO
CREATE OR REPLACE PROCEDURE ANADIRR_EMPLEADO(W_DNI IN EMPLEADO.DNI%TYPE, W_NOMBRE IN EMPLEADO.NOMBRE%TYPE, W_APELLIDOS IN EMPLEADO.APELLIDOS%TYPE, W_TELEFONO IN EMPLEADO.TELEFONO%TYPE,
W_DIRECCION IN EMPLEADO.DIRECCION%TYPE, W_CARGO IN EMPLEADO.CARGO%TYPE, W_CAPITALSOCIAL IN EMPLEADO.CAPITALSOCIAL%TYPE, W_FECHACONTRATACION IN EMPLEADO.FECHACONTRATACION%TYPE,
W_DIASVACACIONES IN EMPLEADO.DIASVACACIONES%TYPE, W_OID_MAQ IN EMPLEADO.OID_MAQ%TYPE)
AS

BEGIN
      INSERT INTO EMPLEADO (DNI, NOMBRE, APELLIDOS, TELEFONO, DIRECCION, CARGO, CAPITALSOCIAL, FECHACONTRATACION, DIASVACACIONES, OID_MAQ) 
    VALUES (W_DNI, W_NOMBRE, W_APELLIDOS, W_TELEFONO, W_DIRECCION, W_CARGO, W_CAPITALSOCIAL, W_FECHACONTRATACION, W_DIASVACACIONES, W_OID_MAQ);

    COMMIT WORK;
EXCEPTION
    WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('Se ha producido un error al añadir el empleado ');
    
END ANADIRR_EMPLEADO;
/


--SOLICITAR DIAS VACACIONES

CREATE OR REPLACE PROCEDURE SOLICITARDIAS (W_DNI IN EMPLEADO.DNI%TYPE, W_DIAS IN PETICIONDIAS.DIAS%TYPE,W_MOTIVO IN PETICIONDIAS.MOTIVO%TYPE)
AS  
    TIPO_EMPLEADO EMPLEADO%ROWTYPE;

BEGIN
    SELECT * INTO TIPO_EMPLEADO FROM EMPLEADO WHERE W_DNI = DNI;

    INSERT INTO PETICIONDIAS (OID_EMP,DIAS,MOTIVO) VALUES (TIPO_EMPLEADO.OID_EMP, W_DIAS, W_MOTIVO);
END SOLICITARDIAS;
/
--ACEPTARPETICIONDIAS
CREATE OR REPLACE PROCEDURE ACEPTARPETICIONDIAS (W_OID_PETICIONDIAS IN PETICIONDIAS.OID_PETICIONDIAS%TYPE)
AS  
    PETICION PETICIONDIAS%ROWTYPE;

BEGIN
    SELECT * INTO PETICION FROM PETICIONDIAS WHERE W_OID_PETICIONDIAS = OID_PETICIONDIAS;

    UPDATE PETICIONDIAS 
    SET ACEPTADA = 1 WHERE W_OID_PETICIONDIAS = OID_PETICIONDIAS;
    UPDATE EMPLEADO
    SET DIASVACACIONES = DIASVACACIONES-PETICION.DIAS WHERE OID_EMP = PETICION.OID_EMP;
    COMMIT WORK;
END ACEPTARPETICIONDIAS;
/
--DENEGARPETICIONDIAS
CREATE OR REPLACE PROCEDURE DENEGARPETICIONDIAS (W_OID_PETICIONDIAS IN PETICIONDIAS.OID_PETICIONDIAS%TYPE)
AS  

BEGIN

    UPDATE PETICIONDIAS 
    SET ACEPTADA = 0 WHERE W_OID_PETICIONDIAS = OID_PETICIONDIAS;
    COMMIT WORK;
END DENEGARPETICIONDIAS;
/

--Actualizar cliente
CREATE OR REPLACE PROCEDURE ACTUALIZARCLIENTE (W_OID_CLI IN CLIENTE.OID_CLI%TYPE, W_CIF IN CLIENTE.CIF%TYPE
, W_NOMBRE IN CLIENTE.NOMBRE%TYPE, W_DIRECCION IN CLIENTE.DIRECCION%TYPE, W_TELEFONO IN CLIENTE.TELEFONO%TYPE, W_EMAIL IN CLIENTE.EMAIL%TYPE)

AS
    W_CLIENTE CLIENTE%ROWTYPE;
    
BEGIN
    SELECT * INTO W_CLIENTE FROM CLIENTE WHERE W_OID_CLI = OID_CLI;
    
    UPDATE CLIENTE
    SET CIF = W_CIF , NOMBRE = W_NOMBRE, DIRECCION = W_DIRECCION, TELEFONO = W_TELEFONO , EMAIL=W_EMAIL WHERE  W_OID_CLI=OID_CLI;
    COMMIT WORK;
EXCEPTION
    WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('Se ha producido un error al actualizar el cliente con ID '||W_OID_CLI||' ');
    
END ACTUALIZARCLIENTE;
/

--Eliminiar pedido proveedor

CREATE OR REPLACE PROCEDURE QUITAR_PP (W_OID_PEDPROV IN PEDIDOPROVEEDOR.OID_PEDPROV%TYPE) AS
BEGIN
  
  DELETE FROM LINEAPEDIDOPROVEEDOR WHERE OID_PEDPROV = W_OID_PEDPROV;
  DELETE FROM PEDIDOPROVEEDOR WHERE OID_PEDPROV = W_OID_PEDPROV;
 

END;
/

--Eliminar pedido cliente

CREATE OR REPLACE PROCEDURE QUITAR_PC(W_OID_PEDCLI IN PEDIDOCLIENTE.OID_PEDCLI%TYPE) AS
BEGIN
  
  DELETE FROM LINEAPEDIDOCLIENTE WHERE OID_PEDCLI = W_OID_PEDCLI;
  DELETE FROM PEDIDOCLIENTE WHERE OID_PEDCLI = W_OID_PEDCLI;
 

END;

/

--SOLICITAR DIAS VACACIONES

CREATE OR REPLACE PROCEDURE CREAR_PEDIDO_CLIENTE(W_OID_CLI IN PEDIDOCLIENTE.OID_CLI%TYPE, W_OID_EMP IN PEDIDOCLIENTE.OID_EMP%TYPE)
AS  
BEGIN
    INSERT INTO PEDIDOCLIENTE(OID_CLI,OID_EMP) VALUES (W_OID_CLI, W_OID_EMP);
END CREAR_PEDIDO_CLIENTE;
/

